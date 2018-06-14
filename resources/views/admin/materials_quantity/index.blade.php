@extends('admin.layout')

@section('content')
<div class="modal fade" id="addMQuantity"   role="dialog" aria-labelledby="addMQuantity"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMQuantityLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addMQuantity" action="/mquantity" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Тип: </label>
                            <select name="material" class="form-control">
                                <option value="">Избер материал</option>
                        
                                @foreach($types as $type)
                                    <option value="{{ $type->id }}">{{ App\Materials_type::withTrashed()->find($type->parent)->name }} - {{ $type->color }} - {{ $type->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="2">Количество:(гр) </label>
                            <input type="number" class="form-control" id="2" name="quantity" placeholder="Количество:" min="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Магазин: </label>
                        <select name="store" class="form-control">
                            <option value="">Избери магазин</option>
                    
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} - {{ $store->location }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="errors-container"></div>
                </div>

                {{-- <input type="hidden" name="store" value="{{  Auth::user()->store }}"> --}}

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editMQuantity" role="dialog" aria-labelledby="editMQuantityLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Налични материали 
            <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addMQuantity">Добави</button>
        </h4>
        <p>Преглед на наличност.</p>
        <table class="table table-condensed">
            <tr>
                <th>Тип</th> 
                <th>Количество/гр</th> 
                <th>Магазин</th>
                <th>Действия</th> 
            </tr>
            
            @foreach($materials as $material)
                @include('admin.materials_quantity.table')
            @endforeach
        </table>
      </div>
    </div>
</div>
@endsection