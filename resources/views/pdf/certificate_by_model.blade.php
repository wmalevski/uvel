<!doctype html>
<html lang="en">
<head></head>
<body style="width: 100%; position: relative; font-family: sans-serif;">
<div style="line-height: 20px; font-size: 10px;">
	<div>{{$material->name}} {{$material->code}}, {{$material->color}}; {{$model->name}}</div>
	@if($stone['isSet'])
	<div>{{$stone['display_name']}} - {{$stone['accumulated_weight']}} гр.</div>
	@endif
	<div style="float:left;width:50%;">Размер: <b>{{$order->size}}</b></div>
	<div style="float:left;width:50%;text-align:right;">Грамаж: <b>{{$weight['weight']}} гр.</b></div>
	<div style="float:left;width:50%;">
		@if(isset($payment->certificate) && $payment->certificate == 'yes')
		<div>Цена: <b>{{$model->price}} лв.</b></div>
		@endif
		<div>{{date('d-m-y')}} cм.№: {{$order->id}}</div>
	</div>
	<div style="float:left;width:50%;text-align:right;">
		<div style="text-align:center;font-size:8px;">№:{{$order->id}}</div>
		<div style="display:flex;flex-direction:column;justify-content:center;align-items:center;">
            <span>{!! $barcode !!}</span>
            <span>{{ $model->barcode }}</span>
        </div>
	</div>
</div>
</body>
</html>