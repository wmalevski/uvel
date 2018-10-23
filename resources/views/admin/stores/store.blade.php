@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Потребители в магазин {{ $store->name }}</h4>
        <p>Преглед на потребителите в магазина.</p>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">Потребител</th> 
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
                @include('admin.stores.usertable')
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endsection