<!DOCTYPE html>
<html lang="en">
<head>
    <title>Email Template</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>

<div style="margin-right: auto; margin-left: auto; padding-left: 15px; padding-right: 15px;">
    <div style="">
        <div>
            <img style="width: 100px; height:50px;" src="{{URL::asset('uploads/logo/1515332341evaib-logo.png')}}" alt="logo">
        </div>
        <div>
            <h2 style="color: #a85400; text-align: right;">Purchase confirmation</h2>
{{--            <p style="text-align: right;">Reference #: P224466460--}}
{{--            </p>--}}
        </div>
    </div>
    <p>
        Hi {{ $bid['user']['name'] }},<br>
        Congratulations on your Buy Now purchase of {{ $bid['ad']['title'] }}!
{{--        {{ $bidData->bid_amount }}--}}
    </p>
    <div style="border: 1px none; border-color: #343a40; background-color: #f8f9fa; padding: 0.75rem;">
        <h1 style="color: #0000cc">{{ $bid['ad']['title'] }}</h1>
        <h3>${{ $bid->bid_amount }} to pay</h3>
        <button type="button" class="btn btn-light" style="height: 50px; padding: 15px;">View payment instructions</button>
    </div>
    <div style="border: 1px none; border-color: #343a40; background-color: #f8f9fa; padding: 0.75rem;  margin-top: 3rem; margin-bottom: 3rem;">
        <h1 style="color: #6c757d;">Purchase Details</h1>
        <table style=" width: 100%; margin-bottom: 1rem; color: #212529; border: none; background-color: #f8f9fa;">
            <tbody>
            <tr>
                <td><strong>Item</strong></td>
                <td><strong>{{ $bid['ad']['title'] }}</strong></td>
            </tr>
            <tr>
                <td>Reference #</td>
                <td>P224466460</td>
            </tr>
            <tr>
                <td>Price</td>
                <td>{{ $bid->bid_amount }}</td>
            </tr>
            <tr>
                <td>Subtotal</td>
                <td>{{ $bid->bid_amount }}</td>
            </tr>
            <tr>
                <td></td>
                <td>{{ $bid->bid_amount }}</td>
            </tr>
            <tr>
                <td>Payment options</td>
                <td>New Zealand bank deposit, or cash</td>
            </tr>
            <tr>
                <td>Seller</td>
                <td>{{ $bid['ad']['user']['email'] }}</td>
            </tr>
            </tbody>
        </table>
    </div>
    <div style="border: 1px none; border-color: #343a40; background-color: #f8f9fa; padding: 0.75rem;  margin-top: 3rem; margin-bottom: 3rem;">
        <h1 style="color: #6c757d;">Payment instructions from the seller</h1>
        <div style="position: relative; padding: 0.75rem 1.25rem;margin-bottom: 1rem; border: 1px solid transparent; border-radius: 0.25rem; color: #004085;  background-color: #cce5ff; border-color: #b8daff; display: flex; align-items: center; padding: 0.75rem;">
            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 16 16" class="bi bi-info-circle" style="margin-right: 20px;">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm0 14a6 6 0 1 1 0-12 6 6 0 0 1 0 12zm.5-9.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0v-5zM8 7a.5.5 0 0 0-.5.5v.5a.5.5 0 0 0 1 0V8.5A.5.5 0 0 0 8 8zm0-4a.5.5 0 0 0-.5.5v.5a.5.5 0 1 0 1 0V4.5A.5.5 0 0 0 8 4z"/>
            </svg>
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-dark">	Include the reference number P224466460 in your deposit details.</h4>
                <span>It may take a couple of days for your payment to clear.
                <br>Sellers normally ship the goods once payment is received.</span>
                <span></span>
            </div>
        </div>
        <div>
            <p>{!!  nl2br($bid['user']['payment_instr']) !!}</p>
        </div>
    </div>
    <div>
        <p>Thanks for shopping on Trade Me!</p>
        <p>The Trade Me team</p>
    </div>
</div>

</body>
</html>
