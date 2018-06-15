<tr data-id="{{$repair->id}}">
     <td>{!! DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true) !!}</td>  
    <td>{{ $repair->code }}</td>
    <td>{{ $repair->customer_name }}</td> 
    <td>{{ $repair->customer_phone }}</td> 
    <td>{{ App\Repair_types::withTrashed()->find($repair->type)->name }}</td> 
    <td>{{ $repair->created_at }}</td>
    <td>@if($repair->status == 'repairing') <span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">Приет</span> @elseif($repair->status == 'done') <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Готов</span> @else <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Върнат</span>  @endif</td> 

    <td> @if($repair->status == 'repairing') 
        <span data-url="repairs/{{$repair->barcode}}" class="edit-btn" data-toggle="modal" data-target="#fullEditRepair"><i class="c-brown-500 ti-pencil"></i></span> @endif @if($repair->status == 'done') <span class="return-repair-action" data-url="repairs/return/{{$repair->barcode}}" data-toggle="modal" data-target="#returnRepair"><i class="c-brown-500 ti-reload"></i></span> @endif
        <a href="repairs/certificate/{{$repair->id}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a> 
        <span data-url="repairs/delete/{{$repair->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>