<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $title = trans('app.payments');

        $user = Auth::user();
        if ($user->is_admin()) {
            $payments = Payment::with('ad', 'user')->paginate(50);
        } else {
            $payments = Payment::whereUserId($user->id)->with('ad', 'user')->paginate(50);
        }

        return view('admin.payments', compact('title', 'payments'));
    }

    public function paymentInfo($tran_id)
    {
        $payment = Payment::where('local_transaction_id', $tran_id)->first();

        if (! $payment) {
            return view('admin.error.error_404');
        }

        $title = trans('app.payment_info');

        return view('admin.payment_info', compact('title', 'payment'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Checkout Method
     */
    public function checkout($transaction_id)
    {
        $payment = Payment::whereLocalTransactionId($transaction_id)->whereStatus('initial')->first();
        $title = trans('app.checkout');
        if ($payment) {
            return view('checkout', compact('title', 'payment'));
        }

        return view('invalid_transaction', compact('title', 'payment'));
    }

    /**
     * @return array
     *
     * Used by Stripe
     */
    public function chargePayment(Request $request, $transaction_id)
    {
        $payment = Payment::whereLocalTransactionId($transaction_id)->whereStatus('initial')->first();
        $ad = $payment->ad;

        $first_name = $ad->seller_name;
        $last_name = null;
        $payer_email = $ad->payer_email;
        if (Auth::check()) {
            $first_name = $ad->user->first_name;
            $last_name = $ad->user->last_name;
        }

        //Determine which payment method is this
        if ($payment->payment_method == 'paypal') {
            // PayPal settings
            $paypal_action_url = 'https://www.paypal.com/cgi-bin/webscr';
            if (get_option('enable_paypal_sandbox') == 1) {
                $paypal_action_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
            }

            $paypal_email = get_option('paypal_receiver_email');
            $return_url = route('payment_success_url', $transaction_id);
            $cancel_url = route('payment_checkout', $transaction_id);
            $notify_url = route('paypal_notify_url', $transaction_id);

            $item_name = $payment->ad->title.' ('.ucfirst($payment->ad->price_plan).') ad posting';

            // Check if paypal request or response
            $querystring = '';

            // Firstly Append paypal account to querystring
            $querystring .= '?business='.urlencode($paypal_email).'&';

            // Append amount& currency (£) to quersytring so it cannot be edited in html
            //The item name and amount can be brought in dynamically by querying the $_POST['item_number'] variable.
            $querystring .= 'item_name='.urlencode($item_name).'&';
            $querystring .= 'amount='.urlencode($payment->amount).'&';
            $querystring .= 'currency_code='.urlencode($payment->currency).'&';

            $querystring .= 'first_name='.urlencode($first_name).'&';
            $querystring .= 'last_name='.urlencode($last_name).'&';

            //$querystring .= "payer_email=".urlencode($ad->user->email)."&";
            $querystring .= 'payer_email='.urlencode($payer_email).'&';
            $querystring .= 'item_number='.urlencode($payment->local_transaction_id).'&';

            //loop for posted values and append to querystring
            foreach (array_except($request->input(), '_token') as $key => $value) {
                $value = urlencode(stripslashes($value));
                $querystring .= "$key=$value&";
            }

            // Append paypal return addresses
            $querystring .= 'return='.urlencode(stripslashes($return_url)).'&';
            $querystring .= 'cancel_return='.urlencode(stripslashes($cancel_url)).'&';
            $querystring .= 'notify_url='.urlencode($notify_url);

            // Append querystring with custom field
            //$querystring .= "&custom=".USERID;

            // Redirect to paypal IPN
            header('location:'.$paypal_action_url.$querystring);
            exit();
        } elseif ($payment->payment_method == 'stripe') {
            $stripeToken = $request->stripeToken;
            \Stripe\Stripe::setApiKey(get_stripe_key('secret'));
            // Create the charge on Stripe's servers - this will charge the user's card
            try {
                $charge = \Stripe\Charge::create([
                    'amount' => ($payment->amount * 100), // amount in cents, again
                    'currency' => $payment->currency,
                    'source' => $stripeToken,
                    'description' => $payment->ad->title.' ('.ucfirst($payment->ad->price_plan).') ad posting',
                ]);

                if ($charge->status == 'succeeded') {
                    $payment->status = 'success';
                    $payment->charge_id_or_token = $charge->id;
                    $payment->description = $charge->description;
                    $payment->payment_created = $charge->created;
                    $payment->save();

                    //Set publish ad by helper function
                    //Approved ads
                    $ad->status = '1';
                    $ad->save();

                    return ['success' => 1, 'msg' => trans('app.payment_received_msg')];
                }
            } catch (\Stripe\Error\Card $e) {
                // The card has been declined
                $payment->status = 'declined';
                $payment->description = trans('app.payment_declined_msg');
                $payment->save();

                return ['success' => 0, 'msg' => trans('app.payment_declined_msg')];
            }
        }

        return ['success' => 0, 'msg' => trans('app.error_msg')];
    }

    /**
     * @return mixed
     *
     * Payment success url receive from paypal
     */
    public function paymentSuccess(Request $request, $transaction_id = null)
    {
        $title = trans('app.payment_success');

        return view('payment_success', compact('title'));
    }

    /**
     * @return mixed
     *
     * Ipn notify, receive from paypal
     */
    public function paypalNotify(Request $request, $transaction_id)
    {
        $payment = Payment::whereLocalTransactionId($transaction_id)->where('status', '!=', 'success')->first();
        $ad = $payment->ad;

        $verified = paypal_ipn_verify();
        if ($verified) {
            //Payment success, we are ready approve your payment
            $payment->status = 'success';
            $payment->charge_id_or_token = $request->txn_id;
            $payment->description = $request->item_name;
            $payment->payer_email = $request->payer_email;
            $payment->payment_created = strtotime($request->payment_date);
            $payment->save();

            //Approved ads
            $ad->status = '1';
            $ad->save();

        //Sending Email...
        } else {
            $payment->status = 'declined';
            $payment->description = trans('app.payment_declined_msg');
            $payment->save();
        }
        // Reply with an empty 200 response to indicate to paypal the IPN was received correctly
        header('HTTP/1.1 200 OK');
    }
}
