@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal"   role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на статия</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="blog" data-type="add" action="blog" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Заглавие: </label>
                            <input type="text" class="form-control" id="1" name="title" placeholder="Заглавие:">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Описание: </label>
                            <textarea class="form-control" name="excerpt" rows="1"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Съдържание: </label>
                            <textarea id="summernote" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Снимка: </label>
                            <div class="drop-area" name="add">
                                <input type="file" name="images" class="drop-area-input" id="fileElem-add" accept="image/*" >
                                <label class="button" for="fileElem-add">Select some files</label>
                                <div class="drop-area-gallery"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" data-state="add_state" class="action--state_button add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade edit--modal_holder" id="editArticle" role="dialog" aria-labelledby="editArticle"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Блог <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="blog">Добави</button></h4>
      <p>Преглед на създадените новини.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Име</th> 
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($articles as $article)
                @include('admin.blog.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection