<div style="clear: both; font-family: sans-serif;">
    <div style="box-sizing: border-box; width: 28%; float: left; padding-right: 10px; font-size: 8px; text-align: center;">
        {{ $material->name }} - {{ $material->code }} - {{ $material->color }}
        <div style="margin: 2px 0">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",0.9,14,"black", false)) !!}</div>
        {{ $barcode }}
    </div>
    <div style="width: 25%; float: left; font-size: 12px;">
        <table>
            <tr>
                <td text-rotate="-90" style="font-size: 20px;">{{ $product->price }}лв.</td>
                <td style="padding-left: 30px;">
                    Гр: {{ $weight }}<br/>
                    @if($stone['isSet'])
                    {{$stone['display_name']}} - {{$stone['accumulated_weight']}} гр.<br>
                    @endif
                    Р-р: {{ $product->size }}<br/>
                    Изр: {{ $workmanship }}лв.<br/>
                </td>
            </tr>
        </table>
    </div>
    <div style="width: 43%;float:left;font-size:12px;height:35px;text-align:center;line-height:35px;">{{ (strlen($product->model->name)>22?mb_substr($product->model->name,0,22):$product->model->name) }}</div>
</div>
