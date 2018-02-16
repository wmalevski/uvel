@extends('layouts.shop')
@section('aimeos_scripts')
@parent
<script type="text/javascript" src="<?php echo asset('packages/aimeos/shop/themes/aimeos-detail.js'); ?>"></script>
@stop


@section('content')

<h3>Промени бижу</h3>

<form method="POST" name="edit" action="/jewels/{{ $jewel->id }}">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" value="{{ $jewel->name }}" id="1" name="name" placeholder="Име:">
    </div>

    <label>Материал: </label>
    <select name="material" class="form-control">
        <option value="">Избер материал</option>

        @foreach($materials as $material)
            <option value="{{ $material->id }}" @if($jewel->material == $material->id) selected @endif>{{ $material->name }} - {{ $material->code }}</option>
        @endforeach
    </select>
    <br>
    
    <button type="submit" class="btn btn-default">Промени</button>
</form>
@endsection