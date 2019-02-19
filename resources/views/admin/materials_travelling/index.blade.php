@extends('admin.layout')

@section('content')
<div class="modal fade" id="sendMaterial" role="dialog" aria-labelledby="sendMaterial"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendMaterialLabel">Изпращане на материал</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="sendMaterial" data-type="add" action="sendMaterial" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Тип: </label>
                            <select name="material_id" class="form-control" data-search="/ajax/select_search/parentmaterials/">
                                <option value="">Избер материал</option>
                        
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">
                                        {{ $material->material->parent->name }} - {{ $material->material->color }} - {{ $material->material->code }} - {{ $material->store->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="2">Количество:</label>
                            <div class="input-group">
                              <input type="text" class="form-control" id="2" name="quantity" placeholder="Количество:">
                              <span class="input-group-addon">гр.</span>
                            </div>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="3">Магазин: </label>
                            <select name="store_to_id" class="form-control" data-search="/ajax/select_search/stores/">
                                <option value="">Избери магазин</option>
                        
                                @foreach($stores as $store)
                                    @if($store->id != Auth::user()->getStore()->id)
                                        <option value="{{ $store->id }}">
                                            {{ $store->name }} - {{ $store->location }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <input type="hidden" name="store" value="{{  Auth::user()->getStore()->id }}">

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
              <h4 class="c-grey-900 mB-20">Материали на път
                    <button type="button" class="btn btn-primary" data-form-type="add" data-form="materailsTraveling" data-toggle="modal" data-target="#sendMaterial">Изпрати</button>
              </h4>
              <p>Преглед на пътуващите материали.</p>
              <table class="table table-condensed">
                <thead>
                    <tr>
                        <th>Тип</th> 
                        <th>Количество/гр.</th> 
                        <th>Стойност</th> 
                        <th>Изпратен на</th>
                        <th>От магазин</th> 
                        <th>До магазин</th> 
                        <th>Статус</th> 
                        <th>Прием</th> 
                    </tr>
                </thead>
                  
                <tbody>
                    @foreach($travelling as $material)
                        @include('admin.materials_travelling.table')
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
</div>
@endsection
