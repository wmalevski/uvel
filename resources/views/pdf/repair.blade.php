<h3 style="margin: 5px 0; text-align: center;">Магазин за златна и сребърна бижутерия</h3>
<h3 style="margin: 5px 0; text-align: center;">{{ $store->name }} - {{ $store->location }}</h3>
<h4 style="margin: 5px 0; text-align: center;">тел.: {{ $store->phone }}</h4>

<hr/>
@if(isset($repair->barcode))
<div style="position:fixed;top: 120px;right: 0;">{!! str_replace( '<?xml version="1.0" standalone="no"?>', '' ,DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true)) !!}</div>@endif
<h2 style="margin: 10px 0; text-align: center;"><strong>РЕМОНТ @if(isset($repair->id))№: {{$repair->id}}@endif</strong></h2>
<h3 style="margin: 5px 0 20px; text-align: center;">бижутерско изделие</h3>

<hr style="clear:both;"/>
<div style="width:50%;float:left;"><b>Приемане</b>: {{$repair->created_at->format('d-m-Y')}}</div>
<div style="width:50%;float:left;text-align:right;"><b>За получаване: </b> {{$repair->date_returned}}</div>
<hr style="clear:both;"/>
<div style="width:50%;float:left;"><b>Клиент</b>: {{$repair->customer_name}}</div>
<div style="width:50%;float:left;text-align:right;"><b>Тел</b>: {{$repair->customer_phone}}</div>
<hr style="clear:both;"/>
<div style="width:100%"><b>Бижу на клиента: </b>
	<ul>
	@if($material)
		<li>{{$material->name}} {{$material->code}}, {{$material->color}}</li>
		@if(strtolower($material->name)=="злато")
		<li>{{$material->carat}} кт.</li>>
		@endif
	@endif
		<li>Тегло: {{$repair->weight}} гр.</li>
	</ul>
</div>
<hr style="clear:both;"/>
@if($repair_type)
<div style="width:100%"><b>Тип ремонт: </b>{{$repair_type->name}}
<hr style="clear:both;"/>
@endif
<div style="height: 100px"><b>Опис: </b> {{$repair->repair_description}}</div>
<hr style="clear:both;"/>

<div style="float: left; width: 33.33%;"><b>Цена: </b>{{$repair->price}}лв.</div>
<div style="float: left; width: 33.33%;"><b>Капаро: </b>{{$repair->deposit}}лв.</div>
<div style="float: left; width: 33.33%;"><b>Остатък: </b>{{$repair->price - $repair->deposit}}лв.</div>
<hr style="clear:both;"/>

<div style="float: left; width: 50%;"><b>Клиент</b> :</div>
<div style="float: left; width: 50%;"><b style="margin-left: 200px;">Приемчик</strong> :</div>