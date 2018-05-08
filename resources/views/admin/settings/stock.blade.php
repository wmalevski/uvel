@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Борсови цени</h4>
            <form method="POST" action="/admin/settings/stock">
                {{ csrf_field() }}
                <div class="form-row">
                    @foreach($materials as $material)
                        <div class="form-group col-md-2">
                            {{ $material->name }} {{ $material->carat }}к
                            цена: <input type="number" class="form-control" name="stock_price[]" value="{{ $material->stock_price }}">
                            <input type="hidden" class="form-control" name="mat[]" value="{{ $material->id }}">
                            <input type="hidden" class="form-control" name="carat[]" value="{{ $material->carat }}">
                        </div>
                    @endforeach
                </div>
                
                <button type="submit" class="btn btn-primary">Промени цени</button>
            </form>
        </
    </div>
</div>

@endsection