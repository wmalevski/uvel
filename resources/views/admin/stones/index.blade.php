@extends('admin.layout')

@section('content')


<div class="modal fade" id="addStone" tabindex="-1" role="dialog" aria-labelledby="addStoneLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStoneLabel">Добавяне на камък</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/stones" name="addStones">
                <div class="info-cont">
                </div>
                <div class="modal-body">    
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
                        <input type="text" class="form-control" id="weight" name="weight" placeholder="Тегло:">
                    </div>
                
                    <div class="form-group">
                        <label for="carat">Карат: </label>
                        <input type="text" class="form-control" id="carat" value="0" name="carat" placeholder="Карат:" readonly>
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
                        <input type="text" class="form-control" id="4" name="amount" placeholder="Количество:">
                    </div>
                
                    <div class="form-group">
                        <label for="5">Цена: </label>
                        <input type="text" class="form-control" id="5" name="price" placeholder="Цена:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>



<div class="modal fade" id="addStyle" tabindex="-1" role="dialog" aria-labelledby="addStyleLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addStyleLabel">Добавяне на стил</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на стил:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addContour" tabindex="-1" role="dialog" aria-labelledby="addContourLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addContourLabel">Добавяне на контур</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на контур:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="addSize" tabindex="-1" role="dialog" aria-labelledby="addSizeLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addSizeLabel">Добавяне на размер</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">    
                    {{ csrf_field() }}                    
                    <div class="form-group">
                        <label for="1">Име: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Име на размер:">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>


<h4 class="c-grey-900 mT-10 mB-30">Камъни 
    <button class="btn btn-primary" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">Добави</button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" data-toggle="modal" data-target="#addStone">Камък</a>
        <a class="dropdown-item" data-toggle="modal" data-target="#addStyle">Стил</a>
        <a class="dropdown-item" data-toggle="modal" data-target="#addContour">Контур</a>
        <a class="dropdown-item" data-toggle="modal" data-target="#addSize">Размер</a>
    </div>
</h4>
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Simple Table</h4>
      <p>Using the most basic table markup, here’s how
        <code class="highlighter-rouge">.table</code>-based tables look in Bootstrap.
        <strong>All table styles are inherited in Bootstrap 4</strong>, meaning any nested tables will be styled in the
        same manner as the parent.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Име</th> 
            <th scope="col">Тип</th>
            <th scope="col">Тегло</th> 
            <th scope="col">Карат</th>  
            <th scope="col">Размер</th> 
            <th scope="col">Стил</th> 
            <th scope="col">Контур</th> 
            <th scope="col">Количество</th> 
            <th scope="col">Цена</th> 
          </tr>
        </thead>
        <tbody>
            @foreach($stones as $stone)
                <tr>
                    <td scope="col"></td>
                    <td>{{ $stone->name }}</td> 
                    <td> @if($stone->type == 1) Синтатичен  @else Естествен  @endif </td> 
                    <td>{{ $stone->weight }}</td> 
                    <td>{{ $stone->carat }}</td> 
                    <td>{{ App\Stone_sizes::find($stone->size)->name }}</td> 
                    <td>{{ App\Stone_styles::find($stone->style)->name }}</td> 
                    <td>{{ App\Stone_contours::find($stone->contour)->name }}</td> 
                    <td>{{ $stone->amount }}</td> 
                    <td>{{ $stone->price }}</td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection