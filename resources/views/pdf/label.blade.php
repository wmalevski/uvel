{{-- {!! DNS1D::getBarcodeHTML($barcode, "EAN13",1,33,"black", true) !!} <br /> {{ $barcode }}<br /> --}}
{{--{{ $code }}<br/><br/>--}}
<img src="data:image/png;base64,' {{ DNS1D::getBarcodePNG($barcode, "EAN13", true) }} '" alt="barcode"   /> <br /> {{ $barcode }}<br/><br/>
Гр: {{ $weight }} <br/>
Изр: {{ $workmanship }}лв.