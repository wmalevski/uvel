@extends('admin.layout')

@section('content')
<div class="modal fade" id="exampleModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавяне на абонат</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="subscribe" data-type="add" action="subscribe" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="email">Имейл</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Имейл адрес…">
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

<div class="modal fade edit--modal_holder" id="editSubscriber" role="dialog" aria-labelledby="editSubscriber" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">
            Mailchimp Абонати
            <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-form-type="add" data-form="subscribe">
              Добави
            </button>
        </h4>
      <p>Преглед на абонираните потребители.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Email</th> 
            <th scope="col">Статус</th> 
            <th scope="col">Действия</th> 
          </tr>
        </thead>
        <tbody>
            @foreach($subscribers['members'] as $subscriber)
                @include('admin.mailchimp.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
