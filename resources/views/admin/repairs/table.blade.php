<tr data-id="{{$repair->id}}">
	<td>{!! DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true) !!}</td>
	<td>{{$repair->id}}</td>
	<td>{{$repair->customer_name}}</td>
	<td>{{$repair->customer_phone}}</td>
	<td>{{$repair->type->name}}</td>
	<td>{{$repair->date_returned}}</td>
	<td>{{$repair->store_id}}</td>
	<td>@switch($repair->status)
		@case('repairing') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Приет</span>@break
		@case('done') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Готов</span>@break
		@case('returning') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">В процес на връщане</span>@break
		@default <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Върнат</span>@break
	@endswitch</td>
	<td>
		@if($repair->status == 'done')
			<span class="return-repair-action" data-url="repairs/return/{{$repair->id}}" data-repair-return><i class="c-brown-500 ti-reload"></i></span>
		@endif
		@if(in_array(Auth::user()->role, array('storehouse', 'admin')))
			<span data-url="repairs/{{$repair->barcode}}" class="edit-btn" data-form-type="edit" data-form="repairs"
				  data-toggle="modal" data-target="#fullEditRepair"><i class="c-brown-500 ti-pencil"></i></span>
		@endif
		<a data-print-label="true" target="_blank" href="/ajax/repairs/certificate/{{$repair->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
		@if(Auth::user()->role == 'admin') <span data-url="repairs/delete/{{$repair->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>@endif
	</td>
</tr>