<!doctype html>
<html lang="en">
<head></head>
<body style="width: 100%; position: relative; font-family: sans-serif;">
<div style="line-height: 20px; font-size: 10px;">
	<div>{{$material->name}} {{$material->code}}, {{$material->color}}; {{$model->name}}</div>
	@if($stone['isSet'])
	<div>{{$stone['display_name']}} - {{$stone['accumulated_weight']}} гр.</div>
	@endif
	<div style="float:left;width:50%;">Размер: <b>{{$product->size}}</b></div>
	<div style="float:left;width:50%;text-align:right;">Грамаж: <b>{{$weight['weight']}} гр.</b></div>
	<div style="float:left;width:50%;">
		@if(isset($payment->certificate) && $payment->certificate == 'yes')
		<div>Цена: <b>{{$product->price}} лв.</b></div>
		@endif
		<div style="font-size:8px;">{{date('d-m-y')}} cм.№: {{$payment->id}}</div>
	</div>
	<div style="float:left;width:50%;text-align:right;">
		<div style="text-align:center;font-size:8px;">№:{{$product->id}}</div>
		<div style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
            <div>{!! $barcode !!}</div>
            <div>{{$product->barcode}}</div>
        </div>
	</div>
</div>
</body>
</html>