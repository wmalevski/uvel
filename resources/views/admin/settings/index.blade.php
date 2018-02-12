@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Настройки </h4>
            Борсови цени
            <form method="POST" action="/admin/settings/updatePrices">
                {{ csrf_field() }}
                <div class="form-row">
                    @foreach($materials as $material)
                        <div class="form-group col-md-2">
                            {{ $material->carat }}к
                            цена: <input type="text" class="form-control" name="carat[{{ $material->carat }}]" value="{{ $material->stock_price }}">
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Промени цена</button>
            </form>
        </div>
    </div>
</div>

@endsection