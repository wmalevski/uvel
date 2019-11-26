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
            <th scope="col">Email</th> 
            <th scope="col">Телефон</th> 
            <th scope="col">Град</th> 
            <th scope="col">Модел</th> 
            <th scope="col">Статус</th> 
            <th scope="col" data-sort-method="none">Действия</th>
          </tr>

          <tr class="search-inputs" data-dynamic-search-url="ajax/search/orders/model">
            <th>
              <input class="filter-input form-control" type="text" data-dynamic-search-param="byEmail=" placeholder="Търси по имейл">
            </th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                @include('admin.orders.model.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
