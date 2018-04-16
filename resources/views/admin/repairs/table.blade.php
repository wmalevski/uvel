<tr>
    {{--  <td>{!! DNS1D::getBarcodeSVG($repair->barcode, "EAN13",1,33,"black", true) !!}</td>   --}}
    {{--  <td>{{ $repair->code }}</td>   --}}
    <td>{{ $repair->customer_name }}</td> 
    <td>{{ $repair->customer_phone }}</td> 
    <td>{{ App\Repair_types::find($repair->type)->name }}</td> 
    <td>@if($repair->status == 'repairing') Приет @elseif($repair->status == 'done') Готов @else Върнат  @endif</td> 

    <td> @if($repair->status == 'repairing') 
        <a href="repairs/{{$repair->id}}" class="edit-btn" data-toggle="modal" data-target="#fullEditRepair"><i class="c-brown-500 ti-pencil"></i></a> @endif @if($repair->status == 'done') <a href="repairs/return/{{$repair->id}}" class="edit-btn" data-toggle="modal" data-target="#returnRepair"><i class="c-brown-500 ti-reload"></i></a> @endif
        <a href="repairs/{{$repair->id}}" class="edit-btn" data-toggle="modal" data-target="#fullEditRepair"><i class="c-brown-500 ti-info-alt"></i></a>
        <a href="repairs/certificate/{{$repair->id}}" class="edit-btn"><i class="c-brown-500 ti-printer"></i></a> 
        <a href="repairs/{{$repair->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></a>
    </td>
</tr>