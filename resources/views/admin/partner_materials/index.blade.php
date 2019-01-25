@extends('admin.layout')

@section('content')
<div class="modal fade edit--modal_holder" id="editPartnerMaterial" tabindex="-1"  role="dialog" aria-labelledby="editPartnerMaterial">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Материали на партньор {{ $partner->user->name }}</h4>
        <p>Преглед на материалите на партньора.</p>
        <table class="table tablesort">
          <thead>
            <tr>
              <th scope="col">Име</th> 
              <th scope="col">Количество</th> 
              {{-- <th data-sort-method="none" scope="col">Email</th>
              <th scope="col">Вид</th>
              <th scope="col">Магазин</th>
              --}}
              <th data-sort-method="none" scope="col">Действия</th>
            </tr>
          </thead>
          <tbody>
            @foreach($materials as $material)
              @include('admin.partner_materials.table')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection
