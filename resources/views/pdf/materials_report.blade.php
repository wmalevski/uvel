<h3 style="margin:5px 0; text-align:center;">Дневен отчет на Материали</h3>
<h5 style="margin:5px 0; text-align:center;">{{ date('d-m-Y') }}</h5>
<hr/>
@foreach($store as $store)
	<h4 style='text-align:center;padding-bottom:5px;margin:15px 0'>{{$store->name}}, {{$store->location}}</h4>
	<table cellpadding="0" cellspacing="0">
		<thead>
			<tr>
				<th style='border-bottom: 1px solid gray;padding-bottom:5px;' width="20%">Материал</th>
				<th style='border-bottom: 1px solid gray;padding-bottom:5px;' width="20%">Цвят</th>
				<th style='border-bottom: 1px solid gray;padding-bottom:5px;' width="20%">Проба</th>
				<th style='text-align:right;border-bottom: 1px solid gray;padding-bottom:5px;' width="40%">Грамаж</th>
			</tr>
			<tr>
				<th style='height:10px;'></th>
				<th style='height:10px;'></th>
				<th style='height:10px;'></th>
				<th style='height:10px;'></th>
			</tr>
		</thead>
		<tbody>
@if($materials->where('store_id', $store->id)->count() == 0)
			<tr>
				<td colspan="4">Няма наличност</td>
			</tr>
		</tbody>
	</table>
@else
		@foreach($materials->where('store_id', $store->id) as $mat)
			@php
				if(!isset($totals[$store->id])){
					$totals[$store->id]=array();
				}
				if(!isset($totals[$store->id][$mat->material->name])){
					$totals[$store->id][$mat->material->name]=0;
				}
				$totals[$store->id][$mat->material->name]+=$mat->quantity;
			@endphp
			<tr>
				<td style='border-bottom:1px dashed #d1d1d1;'>{{$mat->material->name}}</td>
				<td style='border-bottom:1px dashed #d1d1d1;text-align:center;'>{{$mat->material->color}}</td>
				<td style='border-bottom:1px dashed #d1d1d1;text-align:center;'>{{$mat->material->code}}</td>
				<td style='border-bottom:1px dashed #d1d1d1;text-align:right;'>{{$mat->quantity}} гр.</td>
			</tr>
		@endforeach
		</tbody>
	</table>
	<h4 style="margin:10px 0 0 0;text-align:center;">Тотал</h4>
	@if(isset($totals[$store->id]))
	@foreach($totals[$store->id] as $material=>$weight)
		<div style="margin:0 auto;width:50%;">
			<div style="width:50%;float:left;">{{$material}}</div>
			<div style="width:50%;float:left;text-align:right;">{{$weight}} гр.</div>
			<span style='clear:both;'></span>
		</div>
	@endforeach
	@endif
@endif
	<hr style="margin-bottom:20px;"/>
@endforeach