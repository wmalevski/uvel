@extends('admin.layout')


@section('content')
<div class="modal fade" id="addMQuantity" tabindex="-1" role="dialog" aria-labelledby="addMQuantity"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMQuantityLabel">Добавяне на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addMQuantity" action="/mquantity">
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
                                    <option value="{{ $type->id }}">{{ $type->name }} - {{ $type->color }} - {{ $type->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="2">Количество: </label>
                            <input type="text" class="form-control" id="2" name="quantity" placeholder="Проба:">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="3">В 14 Карата: </label>
                            <input type="text" class="form-control" id="3" name="carat" placeholder="Цвят:">
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <input type="hidden" name="store" value="{{  Auth::user()->store }}">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="sendMaterial" tabindex="-1" role="dialog" aria-labelledby="sendMaterial"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMaterialLabel">Изпращане на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="sendMaterial" action="/sendMaterial">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Тип: </label>
                            <select name="type" class="form-control">
                                <option value="">Избер материал</option>
                        
                                @foreach($materials as $material)
                                    <option value="{{ $material->material }}">
                                        {{ App\Materials::find($material->material)->name }} - {{ App\Materials::find($material->material)->color }} - {{ App\Materials::find($material->material)->code }} ({{ $material->quantity }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="2">Количество: </label>
                            <input type="text" class="form-control" id="2" name="quantity" placeholder="Проба:">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="3">Магазин: </label>
                            <select name="storeTo" class="form-control">
                                <option value="">Избери магазин</option>
                        
                                @foreach($stores as $store)
                                    <option value="{{ $store->id }}">
                                        {{ $store->name }} - {{ $store->location }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <input type="hidden" name="store" value="{{  Auth::user()->store }}">
                <input type="hidden" name="quantityID" value="{{ $material->id }}">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Налични материали 
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMQuantity">Добави</button>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#sendMaterial">Изпрати</button>
        </h4>
        <p>Преглед на наличност.</p>
        <table class="table table-condensed">
            <tr>
                <th>#</th>
                <th>Тип</th> 
                <th>Количество</th> 
                <th>В 14 Карата</th> 
                <th>Действия</th> 
            </tr>
            
            @foreach($materials as $material)
                @include('admin.materials_quantity.table')
            @endforeach
        </table>
      </div>
    </div>

    <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Материали на път
              </h4>
              <p>Преглед на пътуващите материали.</p>
              <table class="table table-condensed">
                  <tr>
                      <th>#</th>
                      <th>Тип</th> 
                      <th>Количество</th> 
                      <th>Стойност</th> 
                      <th>Изпратен на</th> 
                      <th>Статус</th> 
                  </tr>
                  
                  @foreach($travelling as $material)
                      @include('admin.materials_quantity.travelling')
                  @endforeach
              </table>
            </div>
          </div>
</div>
@endsection