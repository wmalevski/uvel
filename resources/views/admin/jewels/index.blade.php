@extends('admin.layout')

@section('content')
<div class="modal faded add--modal_holder" id="addJewel" role="dialog" aria-labelledby="addJewel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editJewel" role="dialog" aria-labelledby="editJewel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Вид бижу <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addJewel" data-form-type="add" data-form="jewels" data-url="jewels/create">Добави</button></h4>
      <p>Преглед на създадените видове бижута.</p>
      <table id="main_table" class="table table-fixed">
        <thead>
            <tr data-sort-method="thead">
                <th scope="col">Име</th> 
                <th scope="col" data-sort-method="none">Действия</th>
            </tr>
            <tr class="search-inputs" data-dynamic-search-url="ajax/search/jewels/">
                <th>
                    <input class="filter-input form-control" name="search" type="text" data-dynamic-search-param="byName=" placeholder="Име">
                </th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($jewels as $jewel)
                @include('admin.jewels.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
