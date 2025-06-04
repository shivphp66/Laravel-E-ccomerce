<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Email</title>
</head>
<body>
    @if ($mailData['userType']=='customer')
    <h1>Thanks for your order!!</h1>
    <h2>Your Order ID is: # {{$mailData['order']->id }}</h2>

    @else
    <h1>You have rivieved ad order : </h1>
    <h2>Your Order ID is: # {{$mailData['order']->id }}</h2>

    @endif

    <address>
        <strong>{{$mailData['order']->address}}</strong><br>
        {{$mailData['order']->address}}<br>
        {{$mailData['order']->city}}, {{$mailData['order']->state}} <br>{{$mailData['order']->zip}} {{ getCountryInfo($mailData['order']->country_id)->name }}<br>
        Phone: {{ $mailData['order']->mobile }}<br>
        Email: {{ $mailData['order']->email }}
    </address>

    <table width="700px" cellpading="3" cellspacing="3" border="0">
        <thead>
            <tr style="background:#57555581; text-align: left;">
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($mailData['order']->items as $orderItem)
            <tr>
                <td>{{ $orderItem->name }}</td>
                <td>₹{{ number_format($orderItem->price,2) }}</td>
                <td>{{ $orderItem->qty }}</td>
                <td>₹{{ number_format($orderItem->total,2) }}</td>
            </tr>
            @endforeach
           <tr>
                 <th colspan="4"><hr></th>
            </tr>

            <tr>
                 <th></th>
                  <th></th>
                <th class="text-right">Subtotal:</th>
                <td>₹{{ number_format($mailData['order']->subtotal,2) }}</td>
            </tr>
            <tr>
                <th></th>
                  <th></th>
                <th class="text-right">Discount: {{ (!empty($mailData['order']->coupon_code))? '('.$mailData['order']->coupon_code.')' : ''}}</th>
                <td>₹{{number_format($mailData['order']->discount,2)}}</td>
            </tr>
            <tr>
                <th></th>
                  <th></th>
                <th class="text-right">Shipping:</th>
                <td>₹{{ number_format($mailData['order']->shipping,2) }}</td>
            </tr>
            <tr>
                <th></th>
                  <th></th>
                <th class="text-right">Grand Total:</th>
                <td>₹{{ number_format($mailData['order']->grand_total,2) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
