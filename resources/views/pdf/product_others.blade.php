<div style="clear: both; font-family: sans-serif;">
    <div style="box-sizing: border-box; width: 30%; float: left; padding-right: 10px; font-size: 8px; text-align: center;">
        <div style="margin: 2px 0">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($barcode, "EAN13",0.9,14,"black", false)) !!}</div>
        {{ $barcode }}
    </div>
    <div style="width: 30%; float: left; font-size: 12px;">
        <table>
            <tr>
                <td text-rotate="-90" style="font-size: 20px;">{{ $productOther->price }}лв.</td>
                <td style="padding-left: 10px;">
                    {{ $productOther->name }} <br/>
                    {{ $productOtherType }} <br/>
                </td>
            </tr>
        </table>
    </div>
</div>