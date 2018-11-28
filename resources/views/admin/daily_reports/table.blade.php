<tr data-id="{{ $report->id }}">
    <td>{{ $report->store->name }}</td>
    <td>{{ $report->user->name }}</td>
    <td>{{ $report->user->name }}</td>
    <td>{{ $report->safe_amount }}</td>
    <td>{{ $report->calculated_price }}</td>
    <td>{{ $report->created_at }}</td>
    <td>
        <span data-url="dailyReports/{{$report->id}}" class="edit-btn" data-form-type="edit" data-form="dailyReports" data-toggle="modal" data-target="#editDailyReport"><i class="c-brown-500 ti-pencil"></i></span>
        <span data-url="dailyReports/delete/{{$report->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
    </td>
</tr>