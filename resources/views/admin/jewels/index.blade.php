@extends('admin.layout')


@section('content')

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на бижу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Име:">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Материал: </label>
                            <select name="material" class="form-control">
                                <option value="">Избер материал</option>
                        
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }} - {{ $material->code }}</option>
                                @endforeach
                            </select>
                        </div>
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

{{--  <div class="row gap-20 masonry pos-r">
    <div class="masonry-sizer col-md-6"></div>
    <div class="masonry-item col-md-6">
        <div class="bgc-white p-20 bd">
            <h6 class="c-grey-900">Добави вид бижу</h6>
            <div class="mT-30">
                <form method="POST" action="">
                        {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="1">Име: </label>
                            <input type="text" class="form-control" id="1" name="name" placeholder="Име:">
                        </div>
        
                        <div class="form-group col-md-6">
                            <label>Материал: </label>
                            <select name="material" class="form-control">
                                <option value="">Избер материал</option>
                        
                                @foreach($materials as $material)
                                    <option value="{{ $material->id }}">{{ $material->name }} - {{ $material->code }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Добави</button>
                </form>
            </div>
        </div>
    </div>
</div>  --}}

{{--  <div class="mT-30">
    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">Добави</button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#">Бижу</a>
        </div>
    </div>
</div>  --}}
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Вид бижу <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Добави</button></h4>
      <p>Преглед на създадените бижута.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Име</th> 
            <th scope="col">Материал</th>
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($jewels as $jewel)
                <tr>
                    <td scope="col"></td>
                    <td>{{ $jewel->name }}</td> 
                    <td>{{ App\Materials::find($jewel->material)->name }}</td> 
                    <td><a href="jewels/{{ $jewel->id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
                </tr>
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection