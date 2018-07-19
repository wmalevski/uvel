@extends('admin.layout')

@section('content')
<div class="modal fade" id="addDiscount"   role="dialog" aria-labelledby="addDiscountLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addDiscountLabel">Добавяне на отстъпка</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" name="addDiscount" action="/discounts" autocomplete="off">
                <div class="modal-body">
                    <div class="info-cont">
                    </div>
                    {{ csrf_field() }}
                    <div id="success-container"></div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="1">Отстъпка: </label>
                            <input type="number" class="form-control" id="1" name="discount" placeholder="Процент отстъпка: " min="0" max="100">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputZip">Валидна до</label>
                            <div class="timepicker-input input-icon form-group">
                                <div class="input-group">
                                    <div class="input-group-addon bgc-white bd bdwR-0">
                                        <i class="ti-calendar"></i>
                                    </div>
                                    <input type="text" name="date_expires" class="form-control bdc-grey-200 start-date" placeholder="Валидна до: " data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="checkbox checkbox-circle checkbox-info peers ai-c mB-15">
                            <input type="checkbox" id="lifetime" name="lifetime" class="peer">
                            <label for="lifetime" class="peers peer-greed js-sb ai-c">
                                <span class="peer peer-greed">Безсрочна</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="2">Потребител: </label>
                            <select name="user" class="form-control">
                                <option value="">Избери</option>

                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->roles->first()['title'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div id="errors-container"></div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
                    <button type="submit" id="add" class="add-btn-modal btn btn-primary">Добави</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="editDiscount" role="dialog" aria-labelledby="editDiscount" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            

        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Отстъпки <button type="button" class="add-btn btn btn-primary" data-toggle="modal" data-target="#addDiscount">Добави</button></h4>
        <p>Преглед на създадените отстъпки.</p>
        <table class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th class="sort-false">Баркод</th> 
                    <th>Отстъпка</th> 
                    <th class="sort-false">Валидна до</th> 
                    <th>Статус</th>
                    <th class="sort-false">Потребител</th>
                    <th class="sort-false">Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach($discounts as $discount)
                    @include('admin.discounts.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection