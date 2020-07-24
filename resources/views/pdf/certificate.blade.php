<!doctype html>
<html lang="en">
<head></head>
<body style="width: 100%; position: relative; font-family: sans-serif;">
<div style="line-height: 20px; font-size: 10px;">
    <div>
        {{ $material->name }} - {{ $material->code }} - {{ $material->color }}; {{ $model->name }}
    </div>
    <div>
        @if(isset($weight['stone']))
            @foreach($weight['stone'] as $productStone => $stone)
                @if(strstr($stone,"кт."))
                    {{ $stone}}
                    @break
                @else
                    {{ $stone}}
                    @break
                @endif
            @endforeach
            <br>
        @endif
    </div>
    <div>
        Размер: <strong>{{ $product->size }}</strong>
    </div>
    <div>
        @if (Illuminate\Support\Str::lower($material->name) == "злато")
            Грамаж: <strong>{{ $weight['weight'] }} гр.</strong>
        @else
            Грамаж: <strong>{{ $product->gross_weight }} гр.</strong>
        @endif
    </div>
    @if($payment->certificate == 'yes')
        <div>
            Цена: <strong>{{ $product->price }} лв.</strong>
        </div>
    @endif
    <div>
        {{ date('d-m-y') }} cм.№: {{ $product->id }}
    </div>
</div>

<div style="position: absolute; bottom: 20px; right: 10px;">
    <div style="padding-bottom: 2px; font-size: 8px; text-align: center;">
        №:{{ $product->id }}
    </div>

    <div>
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", false)) !!}
    </div>
</div>
</body>
</html>
