<div style="clear: both; font-family: Helvetica;">
    <div style="box-sizing: border-box; width: 20%; float: left; padding-right: 10px; font-size: 8px; text-align: center;">
        {{ $material->name }} - {{ $material->code }}
        <div style="margin: 2px 0">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",0.9,14,"black", false)) !!}</div>
        {{ $barcode }}
    </div>
    <div style="width: 25%; float: left;">
        <table>
            <tr>
                <td text-rotate="-90" style="font-size: 28px; font-weight: bold;">{{ $product->price }}лв</td>
                <td style="padding-left: 15px; font-size: 28px; font-weight: bold;">
                    Гр: @if(isset($product->weight_without_stones) && $product->weight_without_stones == 'yes') {{ $product->weight }} @else {{ $product->gross_weight }} @endif<br/>
                    Р-р: {{ $product->size }}<br/>
                    @if(isset($product->weight_without_stones) && $product->weight_without_stones == 'yes') Изр:{{ $workmanship }}лв @else Цена:{{ $product->price }}лв @endif<br/>
                    <br/>
                </td>
            </tr>
        </table>
    </div>
    <div style="padding-left: -10px; width: 45%;float:left;font-size:8px;font-weight: bold;height:35px;text-align:left;line-height:35px;">
    {{ (strlen($product->model->name)>22?mb_substr($product->model->name,0,22):$product->model->name) }}-
    @if($stone['isSet']) {{$stone['accumulated_weight']}}гр @endif
    </div>
</div>