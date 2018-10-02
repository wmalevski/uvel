@extends('admin.layout')

@section('content')


<div class="modal fade" id="addStone"   role="dialog" aria-labelledby="addStoneLabel"
aria-hidden="true">
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
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <select name="type" id="stone_type" data-calculateCarats-type class="form-control">
                        <option value="1">Синтетичен</option>
                        <option value="2">Естествен</option>
                    </select>
                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
                    </div>
                
                    <div class="form-group">
                        <label for="weight">Тегло: </label>
                        <div class="input-group">
                            <input type="number" class="form-control weight" id="weight" name="weight" data-calculateCarats-weight placeholder="Тегло:">
                            <span class="input-group-addon">гр.</span>
                        </div>
                    </div>
                
                    <div class="form-group">
                        <label for="carat">Карат: </label>
                        <input type="number" class="form-control carat" id="carat" value="0" name="carat" data-calculateCarats-carat placeholder="Карат:" readonly>
                    </div>
                
                    <label>Размер: </label>
                    <select name="size_id" class="form-control">
                        <option value="">Избер размер</option>
                
                        @foreach($stone_sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Контур: </label>
                    <select name="contour_id" class="form-control">
                        <option value="">Избери контур</option> 
                            
                        @foreach($stone_contours as $contour)
                            <option value="{{ $contour->id }}">{{ $contour->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Стил: </label>
                    <select name="style_id" class="form-control">
                        <option value="">Избери стил</option>
                
                        @foreach($stone_styles as $style)
                            <option value="{{ $style->id }}">{{ $style->name }}</option>
                        @endforeach
                    </select>
                    <br/>
                
                    <div class="form-group">
                        <label for="4">Количество: </label>
                        <input type="number" class="form-control" id="4" name="amount" placeholder="Количество:">
                    </div>
                
                    <div class="form-group">
                        <label for="5">Цена: </label>
                        <div class="input-group">
                            <input type="number" class="form-control" id="5" name="price" placeholder="Цена:">
                            <span class="input-group-addon">лв</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Магазин: </label>
                        <select name="store_id" class="form-control">
                            <option value="">Избери магазин</option>
                    
                            @foreach($stores as $store)
                                <option value="{{ $store->id }}">{{ $store->name }} - {{ $store->location }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
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

<div class="modal fade edit--modal_holder" id="editStone" role="dialog" aria-labelledby="editStone"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Камъни <button class="add-btn btn btn-primary" type="button" id="dropdownMenuButton" data-form-type="add" data-form="stones" data-toggle="modal" data-target="#addStone">Добави</button></h4>
      <p>Преглед на камъни</p>
      <table class="table tablesort">
        <thead>
          <tr>
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
            <th class="sort-false" scope="col">Действия</th>
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