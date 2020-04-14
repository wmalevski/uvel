@extends('admin.layout')

@section('content')

<div class="modal fade edit--modal_holder" id="editPartner" tabindex="-1"  role="dialog" aria-labelledby="editPartner">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Партньори</h4>
        <p>Преглед на партньорите.</p>
        <table id="main_table" class="table tablesort">
          <thead>
            <tr>
              <th scope="col">Потребител</th>
              <th scope="col">Дължима сума</th> 
              <th data-sort-method="none" scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            @foreach($partners as $partner)
              @include('admin.partners.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection
