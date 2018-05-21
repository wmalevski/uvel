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
            <form method="POST" id="add-stones-form" action="/stones" name="addStones" autocomplete="off">
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <select name="type" id="stone_type" class="form-control">
                        <option value="1">Синтатичен</option>
                        <option value="2">Естествен</option>
                    </select>
                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
                    </div>
                
                    <div class="form-group">
                        <label for="weight">Тегло: </label>
                        <input type="number" class="form-control" id="weight" name="weight" placeholder="Тегло:">
                    </div>
                
                    <div class="form-group">
                        <label for="carat">Карат: </label>
                        <input type="number" class="form-control" id="carat" value="0" name="carat" placeholder="Карат:" readonly>
                    </div>
                
                    <label>Размер: </label>
                    <select name="size" class="form-control">
                        <option value="">Избер размер</option>
                
                        @foreach($stone_sizes as $size)
                            <option value="{{ $size->id }}">{{ $size->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Контур: </label>
                    <select name="contour" class="form-control">
                        <option value="">Избери контур</option> 
                            
                        @foreach($stone_contours as $contour)
                            <option value="{{ $contour->id }}">{{ $contour->name }}</option>
                        @endforeach
                    </select>
                
                    <label>Стил: </label>
                    <select name="style" class="form-control">
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
                        <input type="number" class="form-control" id="5" name="price" placeholder="Цена:">
                    </div>
                    
                    <div class="drop-area" name="add">
                        <input type="file" name="images" class="drop-area-input" id="fileElem-add" multiple accept="image/*" >
                        <label class="button" for="fileElem-add">Select some files</label>
                        <div class="drop-area-gallery"></div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editStone" role="dialog" aria-labelledby="editStone"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Камъни <button class="add-btn btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="modal" data-target="#addStone">Добави</button></h4>
      <p>Преглед на камъни</p>
      <table class="table">
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
            <th scope="col">Цена</th> 
            <th scope="col">Действия</th>
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