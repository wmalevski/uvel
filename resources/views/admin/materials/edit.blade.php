@extends('layouts.shop')
@section('aimeos_scripts')
@parent
<script type="text/javascript" src="<?php echo asset('packages/aimeos/shop/themes/aimeos-detail.js'); ?>"></script>
@stop


@section('content')
<h3>Редактиране на материал: {{ $material->name }}</h3>

<form method="POST" class="form-inline" action="">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" value="{{ $material->name }}" id="1" name="name" placeholder="Вид/Име:">
    </div>

    <div class="form-group">
        <label for="2">Проба: </label>
        <input type="text" class="form-control" value="{{ $material->code }}" id="2" name="code" placeholder="Проба:">
    </div>

    <div class="form-group">
        <label for="3">Цвят: </label>
        <input type="text" class="form-control" value="{{ $material->color }}" id="3" name="color" placeholder="Цвят:">
    </div>

    <button type="submit" class="btn btn-default">Промени</button>
</form>

@foreach ($errors->all() as $message)
    <div class="bg-danger"> {{ $message }} </div>
@endforeach
@endsection