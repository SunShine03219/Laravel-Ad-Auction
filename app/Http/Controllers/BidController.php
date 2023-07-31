<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\Ad;
use App\Models\Bid;
use App\Models\User;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BidController extends Controller
{
    public function index($ad_id)
    {
        $user = Auth::user();
        $user_id = $user->id;
        $ad = Ad::find($ad_id);

        $title = trans('app.bids_for').' '.$ad->title;

        if (! $user->is_admin()) {
            if ($ad->user_id != $user_id) {
                return view('admin.error.error_404');
            }
        }

        return view('admin.bids', compact('title', 'ad'));
    }

    public function postBid(Request $request, $ad_id)
    {
        if (! Auth::check()) {
            return redirect(route('login'))->with('error', trans('app.login_first_to_post_bid'));
        }
        $user = Auth::user();
        $bid_amount = $request->bid_amount;

        $ad = Ad::find($ad_id);
        $current_max_bid = $ad->current_bid();

        if ($bid_amount <= $current_max_bid) {
            return back()->with('error', sprintf(trans('app.enter_min_bid_amount'), themeqx_price($current_max_bid)));
        }

        $data = [
            'ad_id' => $ad_id,
            'user_id' => $user->id,
            'bid_amount' => $bid_amount,
            'is_accepted' => 0,
        ];

        Bid::create($data);

        return back()->with('success', trans('app.your_bid_posted'));
    }

    public function bidAction(Request $request)
    {
        $action = $request->action;
        $ad_id = $request->ad_id;
        $bid_id = $request->bid_id;

        $user = Auth::user();
        $user_id = $user->id;
        $ad = Ad::find($ad_id);

        if (! $user->is_admin()) {
            if ($ad->user_id != $user_id) {
                return ['success' => 0];
            }
        }

        $bid = Bid::with(['ad', 'user'])->find($bid_id);
//        return response()->json($bid);
        switch ($action) {
            case 'accept':
                $bid->is_accepted = 1;
                $bid->save();
                SendEmailJob::dispatch($bid);
                break;
            case 'delete':
                $bid->delete();
                break;
        }

        return ['success' => 1];
    }

    public function bidderInfo($bid_id)
    {
        $bid = Bid::find($bid_id);
        $title = trans('app.bidder_info');

        $auth_user = Auth::user();
        $user_id = $auth_user->id;
        $ad = Ad::find($bid->ad_id);

        if (! $auth_user->is_admin()) {
            if ($ad->user_id != $user_id) {
                return view('admin.error.error_404');
            }
        }

        $user = User::find($bid->user_id);

        return view('admin.profile', compact('title', 'user'));
    }
}
