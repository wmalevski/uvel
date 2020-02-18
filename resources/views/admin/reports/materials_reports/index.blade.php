@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20"> Материали </h4>
      <p>Преглед на наличните материали.</p>
      <table id="main_table" class="table">
        <thead>
          <tr>
            <th scope="col">Материал</th>
            @foreach($stores as $store)
            <th scope="col">{{ $store->name }} - {{ $store->location }}</th>
            @endforeach
          </tr>
        </thead>
        <tbody>
            @foreach($materials_quantities as $materials_quantity)
              @include('admin.reports.materials_reports.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
