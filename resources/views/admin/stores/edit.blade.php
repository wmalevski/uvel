@extends('layouts.shop')
@section('aimeos_scripts')
@parent
<script type="text/javascript" src="<?php echo asset('packages/aimeos/shop/themes/aimeos-detail.js'); ?>"></script>
@stop


@section('content')
<h3>Магазини. Промяна на магазин</h3>

<form method="POST" class="form-inline" action="">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" value="{{ $store->name }}" id="1" name="name" placeholder="Име на магазин:">
    </div>

    <div class="form-group">
        <label for="1">Адрес: </label>
        <input type="text" class="form-control" value="{{ $store->location }}" id="1" name="location" placeholder="Адрес на магазин:">
    </div>

    <div class="form-group">
        <label for="1">Телефон: </label>
        <input type="text" class="form-control" value="{{ $store->phone }}" id="1" name="phone" placeholder="Телефон на магазин:">
    </div>

    <button type="submit" class="btn btn-default">Промени</button>
</form>

@foreach ($errors->all() as $message)
    <div class="bg-danger"> {{ $message }} </div>
@endforeach

@endsection