<!doctype html>
<html lang="en">
<head></head>
<body style="width: 100%; position: relative; font-family: sans-serif;">
<div style="line-height: 20px; font-size: 10px;">
    <div>{{ $material->name }} - {{ $material->code }} - {{ $material->color }}; {{ $model->name }}</div>
    @if(isset($weight['stone']))
    <div>
        @foreach($weight['stone'] as $productStone => $stone)
            {{$stone}}
            <br>
        @endforeach
    </div>
    @endif
    <div>Размер: <strong>{{ $product->size }}</strong></div>
    <div>Грамаж: <b>
        @if (Illuminate\Support\Str::lower($material->name) == "злато") {{ $weight['weight'] }} гр.
        @else {{ $product->gross_weight }} гр.
        @endif
        </b>
    </div>
    @if(isset($payment->certificate) && $payment->certificate == 'yes')
    <div>Цена: <strong>{{ $product->price }} лв.</strong>/div>
    @endif
    <div>{{ date('d-m-y') }} cм.№: {{ $product->id }}</div>
</div>

<div style="position: absolute; bottom: 20px; right: 10px;">
    <div style="padding-bottom: 2px; font-size: 8px; text-align: center;">№:{{ $product->id }}</div>
    <div>
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", false)) !!}
    </div>
</div>
</body>
</html>