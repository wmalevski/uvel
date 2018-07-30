@extends('admin.layout')

@section('content')

<div class="modal fade" id="addCurrency" role="dialog" aria-labelledby="addCurrency"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCurrencyLabel">Добавяне на магазин</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="/settings/currencies" name="addCurrency">
                 
                <div class="modal-body">    
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}  
                                
                    <div class="form-group">
                        <label for="1">Валута: </label>
                        <input type="text" class="form-control" id="1" name="name" placeholder="Валута:">
                    </div>
                
                    <div class="form-group">
                        <label for="2">Курс: </label>
                        <input type="number" class="form-control" id="2" name="currency" placeholder="Курс на валута:" min="0.1" max="99999999999" step="any">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editCurrency" tabindex="-1"  role="dialog" aria-labelledby="editCurrency">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Валути и курсове <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addCurrency">Добави</button></h4>

            <p>Преглед на валути и курсове.</p>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Валута</th> 
                  <th scope="col">Курс</th>
                  <th scope="col">Действия</th>
                </tr>
              </thead>
              <tbody>
                @foreach($currencies as $currency)
                    @include('admin.settings.currencytable')
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
</div>

@endsection