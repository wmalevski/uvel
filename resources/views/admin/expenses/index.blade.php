@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal"   role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на разход</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="expensetypes" data-type="add" action="expense" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Основание: </label>
                            <input type="text" class="form-control" id="1" name="type_id" placeholder="Основание:">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Сума: </label>
                            <input type="number" class="form-control" id="1" name="amount" placeholder="Сума:">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Валута: </label>
                            <input type="number" class="form-control" id="1" name="currency_id" placeholder="Валута:">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="1">Пояснение: </label>
                            <textarea class="form-control" placeholder="Кратко пояснение">

                            </textarea>
                        </div>
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

<div class="modal fade edit--modal_holder" id="editExprense" role="dialog" aria-labelledby="editExprense"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Разходи <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="exprenses">Добави</button></h4>
      <p>Преглед на въведените разходи.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Основание</th> 
            <th scope="col">Сума</th> 
            <th scope="col">Валута</th> 
            <th scope="col">Пояснение</th> 
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($expenses as $type)
                @include('admin.expenses.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection