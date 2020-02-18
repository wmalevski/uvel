<tr data-id="{{ $store->id }}">
    <td>{{ $payment->product_id }}</td>
    <td>{{ \App\Selling::where('product_id', $payment->product_id )->first()->quantity }}</td>
    <td>{{ \App\Selling::where('product_id', $payment->product_id )->first()->price }}</td>
    <td>@if(\App\PaymentDiscount::where('payment_id', $payment->id)->first()) -{{\App\PaymentDiscount::where('payment_id', $payment->id)->first()->discount_code_id/100 * \App\Selling::where('product_id', $payment->product_id )->first()->price }} @else 0 @endif</td>
    <td>@if(\App\PaymentDiscount::where('payment_id', $payment->id)->first()) {{  \App\Selling::where('product_id', $payment->product_id )->first()->price - (\App\PaymentDiscount::where('payment_id', $payment->id)->first()->discount_code_id/100 * \App\Selling::where('product_id', $payment->product_id )->first()->price) }} @else {{ \App\Selling::where('product_id', $payment->product_id )->first()->price }} @endif</td>
    <td>@if($payment->method == 'cash') кеш @else карта @endif</td>
    <td>{{ \App\Selling::where('product_id', $payment->product_id )->first()->created_at }}</td>
    <td>{{ \App\User::where('id', $payment->user_id)->first()->email }}</td>
</tr>
