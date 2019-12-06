<tr data-id="{{ $report->id }}">
    <td>{{ $report->store->name }}</td>
    <td>{{ $report->user->email }}</td>
    <td>
        @if($report->type == 'money')
		    Паричен отчет
		@elseif($report->type == 'jewels')
            По бижута
        @elseif($report->type == 'materials')
            По материали
        @endif
    </td>
    <td>
        @if($report->status == 'unsuccessful')
		    <span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Неуспешен</span>
		@else
            <span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Успешен</span> 
        @endif
    </td>
    <td>{{ $report->created_at }}</td>
    <td>
        <span data-url="dailyreports/{{$report->id}}" class="edit-btn" data-form-type="edit" data-form="dailyReports" data-toggle="modal" data-target="#editDailyReport">
            <i class="c-brown-500 ti-info-alt"></i>
        </span>
        @can('delete')
            <span data-url="dailyreports/delete/{{$report->id}}" class="delete-btn">
                <i class="c-brown-500 ti-trash"></i>
             </span>
        @endcan
    </td>
</tr>
