<div>
{{ $material->name }} - {{ $material->code }} - {{ $material->color }}; {{ $model->name }}
</div>
<div>
    @if(isset($weight['stone']))
        @foreach($weight['stone'] as $productStone => $stone)
            {{ $stone}}
            @if(1 + $productStone < count($weight['stone'])) , @endif
        @endforeach
        <br>
    @endif
</div>
<div>
    Р-р: {{ $product->size }}
</div>
<div>
    Гр: {{ $weight['weight'] }}
</div>
<div>
    {{ $product->price }} лв.
</div>
<div>
    {{ date('d-m-y') }} cм.№: {{ $product->id }}
</div>

{!! DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true) !!}