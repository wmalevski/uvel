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
                    {{ $stone}}
                    @if(1 + $productStone < count($weight['stone'])) , @endif
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
        <div>
            Цена: <strong>{{ $product->price }} лв.</strong>
        </div>
        <div>
            {{ date('d-m-y') }} cм.№: {{ $product->id }}
        </div>
    </div>

    <div style="position: absolute; bottom: 20px; right: 10px;">
        <div style="padding-bottom: 2px; font-size: 8px; text-align: center;">
            {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
        </div>

        <div>
            {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($product->barcode, "EAN13",1,33,"black", true)) !!}
        </div>
    </div>
</body>
</html>
