<!doctype html>
<html lang="en">
<head></head>
<body style="width: 100%; position: relative; font-family: sans-serif;">
<div style="line-height: 20px; font-size: 10px;">
    <div>{{ $material->name }} - {{ $material->code }} - {{ $material->color }}; {{ $model->name }}</div>
    @if($stone['isSet'])
    <div>{{$stone['display_name']}} - {{$stone['accumulated_weight']}} гр.</div>
    @endif
    <div style="float:left;width:50%;">Размер: <b>{{$product->size}}</b></div>
    <div style="float:left;width:50%;text-align:right;">Грамаж: <b>{{$weight['weight']}} гр.</b></div>
    <div style="float:left;width:50%;">
        @if(isset($payment->certificate) && $payment->certificate == 'yes')
        <div>Цена: <b>{{ $product->price }} лв.</b></div>
        @endif
        <div>{{ date('d-m-y') }} cм.№: {{ $product->id }}</div>
    </div>
    <div style="float:left;width:50%;text-align:right;">
        <div style="text-align:center;font-size:8px;">№:{{ $product->id }}</div>
        <div>{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", false)) !!}</div>
    </div>
</div>
</body>
</html>