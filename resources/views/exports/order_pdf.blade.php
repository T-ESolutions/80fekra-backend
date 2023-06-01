<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order # {{$order->id}}</title>
    <style>
        /* Add your CSS styles here */
    </style>
</head>
<body>
<div class="invoice">
    <div class="header">
        <h1>Order # {{$order->id}}</h1>
    </div>
    <div class="content">
        <div class="invoice-details">
            <div class="left">
                <p>Order Number: {{$order->id}}</p>
                <p>Date: {{\Carbon\Carbon::parse($order->created_at)->format('Y-m-d')}}</p>
            </div>
            <div class="right">
                <p>Customer: {{$order->address->f_name}}  {{$order->address->l_name}}  </p>
                <p>Email: {{$order->address->email}}</p>
                <p>Phone: {{$order->address->phone}}</p>
            </div>
        </div>
        <table>
            <thead>
            <tr>
                <th>Item</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->orderDetails as $details)
                <tr>
                    <td>{{$details->product->title_en}}</td>
                    <td>{{$details->qty}}</td>
                    <td>{{$details->price}}</td>
                    <td>{{$details->total}}</td>

                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr></tr>
            <tr></tr>
            <tr>
                <td colspan="3"></td>
                <td>Total: {{$order->total}}</td>
            </tr>
            </tfoot>
        </table>
    </div>
    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</div>
</body>
</html>
