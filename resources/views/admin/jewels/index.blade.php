@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal"   role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на бижу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="jewels" data-type="add" action="jewels" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Име:">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
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
      <h4 class="c-grey-900 mB-20">Вид бижу <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="jewels">Добави</button></h4>
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
