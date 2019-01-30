@extends('admin.layout')

@section('content')
<div class="modal fade edit--modal_holder" id="editDailyReport" role="dialog" aria-labelledby="editDailyReport"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Дневни разходи от днес <a href="{{ route('create_report') }}" class="add-btn btn btn-primary">Добави</a></h4>
      <p>Преглед на дневните отчети.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Магазин</th> 
            <th scope="col">Потребител</th> 
            <th scope="col">Тип</th> 
            <th scope="col">Статус</th> 
            <th scope="col">Дата</th> 
            <th scope="col" data-sort-method="none">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($dailyReports as $report)
                @include('admin.daily_reports.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
