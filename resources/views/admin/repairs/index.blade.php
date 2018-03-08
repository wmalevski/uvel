@extends('admin.layout') 
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Ремонти</h4>
            <p>Приемане на артикул за ремонт</p>

            <form method="POST" class="form-inline" action="">
                {{ csrf_field() }}
                <div class="form-row">
                    <div class="form-group">
                        <div class="form-group col-md-6">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Име клиент:">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="2">Телефон: </label>
                            <input type="text" class="form-control" id="2" name="phone" placeholder="Телефон на клиент:">
                        </div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-9">
                        <select name="material" class="form-control col-md-9">
                            <option value="">Избери</option>

                            @foreach($repairTypes as $repairType)
                                <option value="{{ $repairType->id }}">{{ $repairType->name }} - {{ $repairType->price }}</option>
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