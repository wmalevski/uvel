@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            @if($errors->any())
                <div class="info-message error">
                    @foreach ($errors->all() as $error)
                        <div id="errors-container">{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            <h4 class="c-grey-900 mB-20">Борсови цени</h4>
            <form method="POST">
                {{ csrf_field() }}
                <div class="form-row">
                    @foreach($materials as $material)
                        <div class="form-group col-md-2">
                            {{ $material->parent->name }}
                            @if($material->name == 'Сребро')
                                {{ $material->code }}
                            @elseif($material->name == 'Злато')
                                {{ $material->carat }}к
                            @endif
                            цена: <div class="input-group"><input type="number" class="form-control" name="stock_price[]" value="{{ $material->stock_price }}"><span class="input-group-addon">лв</span></div>
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