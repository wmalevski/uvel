<div style="clear: both; font-family: sans-serif;">
    <div style="width: 33%; float: left;">
        {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
        {!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG('1234567', "EAN8",1,32,"black", true)) !!}
    </div>
    <div style="width: 30%; float: left; font-size: 12px;">
        Гр: {{ $weight }} <br/>
        @if(isset($stone['stone']))
           {{ $stone[0]}} <br/>
        @endif
        Р-р: {{ $product->size }} <br/>
        Изр: {{ $workmanship }}лв. <br/>
        {{ $product->price }}лв.
    </div>
</div>
