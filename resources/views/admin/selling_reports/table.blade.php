<tr data-id="{{ $store->id }}">
    <td>{{ $store->name }}</td>
    <?php $new = 0; ?>
    @foreach(\App\Selling::where('payment_id',\App\Payment::where('store_id', $store->id)->first()->id)->get() as $data)
        <?php $new += $data->price; ?>
    @endforeach
    <td>{{ $new }}</td>
    <td>{{ $payment->total }}</td>
    <td>{{ $payment->avg_price }}</td>
    <td>{{ $payment->price }}</td>
    <td>
        <span data-url="sellingreportsexport/{{ $store->id }}"  class="edit-btn">
            <a href="sellingreportsexport/{{ $store->id }}"> Детайли</a>
        </span>
    </td>
</tr>
