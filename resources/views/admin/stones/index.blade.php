@extends('admin.layout')

@section('content')

<div class="modal fade" id="topUpStones" role="dialog" aria-labelledby="topUpStones"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNomenclatureLabel">Добавяне на камъни</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" data-type="quantity" name="stonesQuantityIncrease" action="stones/">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Добави бройка: </label>
                        <input type="number" class="form-control" id="1" name="amount" placeholder="Бройка на камъните:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" data-state="add_state" class="action--state_button btn btn-primary add-btn-modal">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="decreaseStones" role="dialog" aria-labelledby="decreaseStones"
     aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addNomenclatureLabel">Извади камъни</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" data-type="quantity" name="stonesQuantityDecrease" action="stones/">
        <div class="modal-body">
          <div class="info-cont">
          </div>
          {{ csrf_field() }}
          <div class="form-group">
            <label for="1">Извади бройка: </label>
            <input type="number" class="form-control" id="1" name="amount" placeholder="Бройка на камъните:">
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
          <button type="submit" data-state="add_state" class="action--state_button btn btn-primary add-btn-modal">Добави</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addStone" role="dialog" aria-labelledby="addStoneLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStoneLabel">Добавяне на камък</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="POST" id="add-stones-form" action="stones" name="stones" data-type="add" autocomplete="off">
        <div class="modal-body">
          <div class="info-cont"></div>
          {{ csrf_field() }}
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="carat">Тип:</label>
            
              <select name="type" id="stone_type" data-calculateCarats-type class="form-control">
                <option value="1">Синтетичен</option>
                <option value="2">Естествен</option>
              </select>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="1">Име (Номенклатура):</label>
              
              <select name="nomenclature_id" class="form-control" data-search="/ajax/select_search/stones/nomenclatures/">
                <option value="">Избери номенклатура</option>
              </select>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="weight">Тегло:</label>
              
              <div class="input-group">
                <input type="number" class="form-control weight" id="weight" name="weight"
                      data-calculateCarats-weight placeholder="Тегло:">
                <span class="input-group-addon">гр.</span>
              </div>
            </div>
          </div>
         
          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="carat">Карат:</label>
              
              <input type="number" class="form-control carat" id="carat" value="0" name="carat"
                     data-calculateCarats-carat placeholder="Карат:" readonly>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Размер:</label>
            
              <select name="size_id" class="form-control" data-search="/ajax/select_search/stones/sizes/">
                <option value="">Избери размер</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Контур:</label>
          
              <select name="contour_id" class="form-control" data-search="/ajax/select_search/stones/contours/">
                <option value="">Избери контур</option>
              </select>
            </div>
          </div>
          
          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Стил:</label>
              
              <select name="style_id" class="form-control" data-search="/ajax/select_search/stones/styles/">
                <option value="">Избери стил</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="4">Количество:</label>
              
              <input type="number" class="form-control" id="4" name="amount" placeholder="Количество:">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label for="5">Цена:</label>
              
              <div class="input-group">
                <input type="number" class="form-control" id="5" name="price" placeholder="Цена:">
                <span class="input-group-addon">лв</span>
              </div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Магазин: </label>
              
              <select name="store_id" class="form-control" data-search="/ajax/select_search/stores/">
                <option value="{{ $stores->first()->id }}">{{ $stores->first()->name }} - {{ $stores->first()->location }}</option>
              </select>
            </div>
          </div>

          <div class="drop-area mt-3" name="add">
            <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*">
            <label class="button" for="fileElem-add">Select some files</label>
            <div class="drop-area-gallery"></div>
          </div>
          
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
          <button type="submit" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade edit--modal_holder" id="editStone" role="dialog" aria-labelledby="editStone" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content"></div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Камъни
        @if(in_array(\Illuminate\Support\Facades\Auth::user()->role , ['admin', 'storehouse']))
          <button class="add-btn btn btn-primary" type="button" id="dropdownMenuButton"
            data-form-type="add" data-form="stones" data-toggle="modal" data-target="#addStone">Добави</button>
         @endif
      </h4>
      <p>Преглед на камъни</p>
      <table id="main_table" class="table tablesort table-fixed">
        <thead>
          <tr data-sort-method="thead">
            <th scope="col">Име</th>
            <th scope="col">Тип</th>
            <th scope="col">Тегло</th>
            <th scope="col">Карат</th>
            <th scope="col">Размер</th>
            <th scope="col">Стил</th>
            <th scope="col">Контур</th>
            <th scope="col">Количество</th>
            <th scope="col">Магазин</th>
            <th scope="col">Цена</th>
            @if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse']))
              <th data-sort-method="none" scope="col">Действия</th>
            @endif
          </tr>
          
          <tr class="search-inputs" data-dynamic-search-url="ajax/search/stones/">
            <th>
              <input class="filter-input form-control" type="text" data-dynamic-search-param="byName=" placeholder="Име">
            </th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($stones as $stone)
            @include('admin.stones.table')
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
