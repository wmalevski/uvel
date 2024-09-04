@extends('admin.layout')

@section('content')

<div class="modal fade edit--modal_holder" id="editOrder" role="dialog" aria-labelledby="editOrder"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>


<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Поръчки</h4>
      <p>Поръчки по модел на клиента.</p>
      <table id="main_table" class="table tablesort table-fixed">
        <thead>
          <tr>
            <th data-sort-method="none">Уникален номер</th>
            <th scope="col">Срок</th>
            <th scope="col">Снимка</th>
            <th scope="col">Email</th>
            <th scope="col">Телефон</th>
            <th scope="col">Град</th>
            <th scope="col">Статус</th>
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
              <th scope="col" data-sort-method="none">Действия</th>
            @endif
          </tr>

          <tr class="search-inputs" data-dynamic-search-url="ajax/search/orders/custom">
            <th></th>
            <th></th>
            <th></th>
            <th>
              <input class="filter-input form-control" type="text" data-dynamic-search-param="byEmail=" placeholder="Имейл">
            </th>
            <th></th>
            <th></th>
            <th></th>
            @if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
              <th></th>
            @endif
          </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @include('admin.orders.custom.table')
            @endforeach
        </tbody>
      </table>
    </div>
    {{ $orders->links() }}
  </div>
</div>
@endsection
