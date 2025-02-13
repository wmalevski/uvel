@extends('admin.layout')

@section('content')
<div class="modal fade add--modal_holder" id="addDiscount" role="dialog" aria-labelledby="addDiscountLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editDiscount" role="dialog" aria-labelledby="editDiscount" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">
            Отстъпки 
            <button data-url="discounts/create" type="button" class="add-btn btn btn-primary" data-form-type="add" data-form="discounts"
            data-toggle="modal" data-target="#addDiscount">
            Добави
            </button>
        </h4>
        <p>Преглед на създадените отстъпки.</p>
        <table id="main_table" class="table table-condensed tablesort table-fixed">
            <thead>
                <tr data-sort-method="thead">
                    <th data-sort-method="none">Баркод</th>
                    <th>Отстъпка</th>
                    <th>Валидна до</th>
                    <th>Статус</th>
                    <th>Потребител</th>
                    <th>Група</th>
                    <th>Използвана</th>
                    <th data-sort-method="none">Действия</th>
                </tr>
                <tr class="search-inputs" data-dynamic-search-url="ajax/search/discounts/">
                    <th>
                        <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byBarcode=" placeholder="Баркод">
                    </th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>
                        <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byUser=" placeholder="Потребител">
                    </th>
                    <th>
                        <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byGroup=" placeholder="Група">
                    </th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($discounts as $discount)
                    @include('admin.discounts.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
