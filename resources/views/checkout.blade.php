@extends('layouts.app')
@section('title') @if( ! empty($title)) {{ $title }} | @endif @parent @endsection

@section('content')


    <div class="page-header search-page-header">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    @if( ! empty($title)) <h2>{{ $title }} </h2> @endif
                    <div class="btn-group btn-breadcrumb">
                        <a href="{{route('home')}}" class="btn btn-warning"><i class="glyphicon glyphicon-home"></i></a>
                        <a href="{{route('payment_checkout', $payment->local_transaction_id)}}" class="btn btn-warning"> @lang('app.checkout')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">



                <div class="checkout-wrap">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="panel-title">@lang('app.review_your_order') </h4>
                        </div>
                        <div class="panel-body">
                            <div class="col-md-9">
                                <table class="table table-striped">
                                    <tr>
                                        <td colspan="2">
                                            <b>{{ $payment->ad->title }}</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <ul>
                                                <li>{{ ucfirst($payment->ad->price_plan) }} @if($payment->ad->mark_ad_urgent == 1) + @lang('app.urgent') @endif @lang('app.posting')</li>
                                            </ul>
                                        </td>
                                        <td>
                                            <b>{{ $payment->currency.' '.$payment->amount }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-3">
                                <div style="text-align: center;">
                                    <h3>@lang('app.order_total')</h3>
                                    <h3><span style="color:green;">{{ $payment->currency.' '.$payment->amount }}</span></h3>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-4 col-xs-offset-4">
                        @if($payment->payment_method == 'stripe')
                            <div class="stripe-button-container">
                                <script
                                        src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                        data-key="{{ get_stripe_key() }}"
                                        data-amount="{{ $payment->amount * 100 }}"

                                        @if(\Illuminate\Support\Facades\Auth::check())
                                        data-email="{{ $lUser->email}}"
                                        @else
                                        data-email="{{ $payment->ad->seller_email}}"
                                        @endif

                                        data-name="{{ get_option('site_name') }}"
                                        data-description="{{ ucfirst($payment->ad->price_plan)." ad posting" }}"
                                        data-currency="{{get_option('currency_sign')}}"
                                        data-image="{{ asset('assets/img/stripe_logo.jpg') }}"
                                        data-locale="auto">
                                </script>
                            </div>

                        @elseif($payment->payment_method == 'paypal')
                            <form action="" method="post" > @csrf
                            <input type="hidden" name="cmd" value="_xclick" />
                            <input type="hidden" name="no_note" value="1" />
                            <input type="hidden" name="lc" value="UK" />
                            <input type="hidden" name="currency_code" value="{{get_option('currency_sign')}}" />
                            <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
                            <button type="submit" class="btn btn-info"> <i class="fa fa-paypal"></i> Submit Payment</button>
                            </form>
                        @endif
                    </div>

                </div>





            </div>
        </div>
    </div>


@endsection

@section('page-js')
    @if($payment->payment_method == 'stripe')
        <script type="text/javascript">
            $(function() {
                $('.stripe-button').on('token', function(e, token){
                    $('#stripeForm').replaceWith('');

                    $.ajax({
                        url : '{{ route('payment_checkout', $payment->local_transaction_id) }}',
                        type: "POST",
                        data: { stripeToken : token.id, _token : '{{ csrf_token() }}' },
                        success : function (data) {
                            if (data.success == 1){
                                toastr.success(data.msg, '@lang('app.success')', toastr_options);
                            }
                        }
                    });
                });
            });
        </script>
    @endif

@endsection