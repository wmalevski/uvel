@extends('admin.layout') 
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Цени</h4>
            <p>Избери материал за да видиш ценовата листа</p>

            <form method="POST" class="form-inline" action="">

                {{ csrf_field() }}

                <div class="form-row  col-md-12">

                    <div class="form-group col-md-3">
                        <select name="material" class="form-control col-md-9">
                            <option value="">Избери</option>

                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">@if($material->parent) {{ App\MaterialType::withTrashed()->find($material->parent)->name }} @endif - {{ $material->code }} - {{ $material->color }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-3">
                        <button type="submit" class="btn btn-primary">Покажи цени</button>
                    </div>
                    
                </div>
            </form>
        </div>
    </div>
</div>
@endsection