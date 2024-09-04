@extends('admin.layout')

@section('content')

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20"> Експорт </h4>
      <p>Преглед на продажби.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Магазин</th> 
            <th scope="col">Стойност</th>
            <th scope="col">Брой продажби</th>
            <th scope="col">Средна продажба</th>
            <th scope="col">Отстъпки лв.</th>
            <th scope="col" data-sort-method="none">След отстъпка лв.</th>
          </tr>
        </thead>
        <tbody>
            @foreach($stores as $store)
              @foreach($payments as $payment)
                @if($payment->store_id == $store->id)
                  @include('admin.selling_reports.table')
                @endif
              @endforeach
            @endforeach
        </tbody>
      </table>
    </div>
    {{ $stores->links() }}
  </div>
</div>
@endsection
