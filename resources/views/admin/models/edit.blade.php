@extends('layouts.shop')
@section('aimeos_scripts')
@parent
<script type="text/javascript" src="<?php echo asset('packages/aimeos/shop/themes/aimeos-detail.js'); ?>"></script>
@stop


@section('content')

<h3>Промени модел</h3>

<form method="POST" name="edit" action="/models/{{ $model->id }}">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" value="{{ $model->name }}" id="1" name="name" placeholder="Име:">
    </div>

    <label>Избери вид бижу: </label>
    <select id="jewel" name="jewel" class="form-control">
        <option value="">Избери</option>

        @foreach($jewels as $jewel)
            <option value="{{ $jewel->id }}" data-price="{{ $jewel->material }}" @if($model->jewel == $jewel->id) selected @endif>{{ $jewel->name }}</option>
        @endforeach
    </select>

    <label>Цена на дребно: </label>
    <select id="retail_price" name="retail_price" class="form-control disabled-first" disabled>
        <option value="">Избери</option>

        @foreach($prices->where('type', 'sell') as $price)
            <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->retail_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
        @endforeach
    </select>

    <label>Цена на едро: </label>
    <select name="wholesale_price" class="form-control disabled-first" disabled>
        <option value="">Избери</option>

        @foreach($prices->where('type', 'sell') as $price)
            <option value="{{ $price->id }}" data-material="{{ $price->material }}" @if($model->wholesale_price == $price->id) selected @endif>{{ $price->slug }} - {{ $price->price }}</option>
        @endforeach
    </select>

    <div class="form-group">
        <label for="1">Тегло: </label>
        <input type="text" class="form-control" id="1" value="{{ $model->weight }}" name="weight" placeholder="Тегло:">
    </div>
    
    <button type="submit" class="btn btn-default">Промени</button>
</form>
@endsection