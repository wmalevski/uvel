@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal"   role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на бижу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addJewel" action="/jewels">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
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
                                    <option value="{{ $material->id }}">{{ $material->name }} - {{ $material->color }} - {{ $material->code }}</option>
                                @endforeach
                            </select>
                        </div>
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

<div class="modal fade" id="editJewel" role="dialog" aria-labelledby="editJewel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editJewelLabel">Редактиране на артикул за ремонт</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/jewels" name="editJewel">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>

                    {{ csrf_field() }}  
                                

                    
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="btn btn-primary">Промени</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Вид бижу <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">Добави</button></h4>
      <p>Преглед на създадените видове бижута.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Име</th> 
            <th scope="col">Материал</th>
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($jewels as $jewel)
                @include('admin.jewels.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection