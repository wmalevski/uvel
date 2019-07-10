@extends('admin.layout')

@section('content')
<div class="modal fade" id="addPrice"   role="dialog" aria-labelledby="addPriceLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPriceLabel">Добавяне на цена</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="prices" data-type="add" action="prices/{{$material->id}}">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                        <div class="form-group">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="slug" placeholder="Етикет:">
                        </div>
                    
                        <div class="form-group">
                            <label for="2">Стойност: </label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="2" name="price" placeholder="Цена:">
                                <span class="input-group-addon">лв / гр.</span>
                            </div>
                        </div>
                    
                        <label>Тип: </label>
                        <select name="type" class="form-control">
                            <option value="">Избери тип</option>
                    
                            <option value="buy">Купува</option>
                            <option value="sell">Продава</option>
                        </select>
                        <input type="hidden" name="material_id" value="{{ $material->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button btn btn-primary  add-btn-modal">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editPrice" role="dialog" aria-labelledby="editPrice"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPriceLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="prices" name="editPrice">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="edit" class="btn btn-primary">Промени</button>
                </div>
            </form>
        </div>
    </div>
</div>


<h4 class="c-grey-900 mT-10 mB-30">Цени за {{ $material->parent->name }} - {{ $material->code }} - {{ $material->color }}
    <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="modal" data-form-type="add" data-form="prices" data-target="#addPrice">Добави</button>
</h4>
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Цени Купува</h4>
        @if(isset($prices)) 
        <table id="table-price-buy" class="table table-condensed buy table-fixed" id="buy">
            <thead>
                <tr>
                    <th data-sort-method="none">#</th>
                    <th data-sort-method="none">Име</th> 
                    <th>Стойност</th>
                    <th data-sort-method="none">Действия</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach($prices->where('type', 'buy') as $indexKey => $price)
                    @include('admin.prices.table')
                @endforeach
            </tbody>
        </table>
        @endif
      </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Цени Продава</h4>
          @if(isset($prices))
          <table id="table-price-sell" class="table table-condensed sell table-fixed" id="sell">
            <thead>
                <tr>
                    <th data-sort-method="none">#</th>
                    <th data-sort-method="none">Име</th> 
                    <th>Стойност</th>
                    <th data-sort-method="none">Действия</th>
                </tr>
            </thead>
              
            <tbody>
                @foreach($prices->where('type', 'sell') as $indexKey => $price)
                    @include('admin.prices.table')
                @endforeach
            </tbody>
          </table>
          @endif
        </div>
      </div>
  </div>
@endsection
