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
            <form method="POST" name="addPrice" action="/prices/{{$material->id}}">
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
                            <input type="number" class="form-control" id="2" name="price" placeholder="Цена:">
                        </div>
                    
                        <label>Тип: </label>
                        <select name="type" class="form-control">
                            <option value="">Избери тип</option>
                    
                            <option value="buy">Купува</option>
                            <option value="sell">Продава</option>
                        </select>
                    
                        <input type="hidden" name="material" value="{{ $material->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editPrice" role="dialog" aria-labelledby="editPrice"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPriceLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/prices" name="editPrice">
                 
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


<h4 class="c-grey-900 mT-10 mB-30">Цени за {{ $material->name }}
    <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#addPrice">Добави</button>
</h4>
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Цени Купува</h4>

        @if(isset($prices)) 
        <table class="table table-condensed" id="buy">
            <tr>
                <th>#</th>
                <th>Име</th> 
                <th>Стойност</th>
                <th>Действия</th>
            </tr>
            
            @foreach($prices->where('type', 'buy') as $indexKey => $price)
                @include('admin.prices.table')
            @endforeach
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
          <table class="table table-condensed" id="sell">
              <tr>
                  <th>#</th>
                  <th>Име</th> 
                  <th>Стойност</th>
                  <th>Действия</th>
              </tr>
              
              @foreach($prices->where('type', 'sell') as $indexKey => $price)
                @include('admin.prices.table')
              @endforeach
          </table>
          @endif
        </div>
      </div>
  </div>
@endsection