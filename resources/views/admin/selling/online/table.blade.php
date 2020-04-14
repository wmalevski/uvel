<tr data-id="{{ $selling->id }}">
    <td style="padding-right: 0;">
        @if($selling->status == 'waiting_user')
            <span class="sell-status sell-status--pending"></span>
        @elseif($selling->status == 'done')
            <span class="sell-status sell-status--done"></span>
        @endif
    </td>
    <td>{{ $selling->user->email }}</td>
    <td>
            @if($selling->shipping_method == 'office_address')
                От куриер
            @elseif($selling->shipping_method == 'store') 
                От магазин
            @elseif($selling->shipping_method == 'home_address')
                До адрес
            @endif
        </td>
    <td>
        @if($selling->payment_method == 'on_delivery')
            Нл. платеж
        @elseif($selling->payment_method == 'paypal') 
            Paypal
        @endif
    </td> 
    <td>{{ $selling->price }}лв.</td> 
    <td>{{ date_format($selling->created_at,"Y-m-d") }}</td>
    <td class="sell-products">
    @foreach(App\UserPaymentProduct::where('payment_id', $selling->id)->get() as $product)
            @if($product->product_id)
                <div class="sell-product-thumbnail">
                    <img class="admin-product-image" src="{{ asset("uploads/products/" .  App\Gallery::where([['table', '=', 'products'],['product_id', '=', $product->id]])->first()['photo']) }}">
                    <span>x {{ $product->quantity }}</span>
                </div>
            @elseif($product->product_other_id)
                <img class="admin-product-image" src="{{ asset("uploads/products_others/" .  App\Gallery::where([['table', '=', 'products_others'],['product_others_id', '=', $product->product_other_id]])->first()['photo']) }}">
            @elseif($product->model_id)
                <img class="admin-product-image" src="{{ asset("uploads/models/" .  App\Gallery::where([['table', '=', 'models'],['model_id', '=', $product->model_id]])->first()['photo']) }}">
            @endif
    @endforeach
    </td>
    @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'manager', 'cashier']))
         <td><span data-url="selling/online/{{$selling->id}}" class="edit-btn" data-form-type="edit" data-form="editPayments" data-toggle="modal" data-target="#editPayment"><i class="c-brown-500 ti-pencil"></i></span></td>
    @endif
</tr>