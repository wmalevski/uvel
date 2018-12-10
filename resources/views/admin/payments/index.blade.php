@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби</h4>
            <p>Преглед на списък с продажбите.</p>
            <form method="POST" action="">
                    {{ csrf_field() }}
                Направи справка:<br/> От: <input type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" name="date_from" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-provide="datepicker" @if(isset($date_from)) value="{{ $date_from }}" @endif>
                <br/>
                До: <input type="text" data-date-autoclose="true" data-date-format="dd-mm-yyyy" name="date_to" class="form-control bdc-grey-200 start-date" placeholder="Дата на връщане" data-date-start-date="{{ Carbon\Carbon::parse(Carbon\Carbon::now())->format('d-m-Y')}}" data-provide="datepicker" @if(isset($date_to)) value="{{ $date_to }}" @endif>
                <br/>
                Търси по номер на продажба:<br/>
                <input type="text" name="by_number" placeholder="Въведи номер" class="form-control" @if(isset($by_number)) value="{{ $by_number }}" @endif><br/>
                Търси по модел:<br/>
                <input type="text" name="by_model" placeholder="Напиши модел" class="form-control">
                <br/>
                <input type="submit" class="btn btn-primary" value="Покажи"/><br/>
            </form>
            <br/>
            <table class="table table-condensed tablesort">
                <thead>
                    <tr>
                        <th>Магазин</th>
                        <th>Дата</th>
                        <th>Сума</th>
                        <th>Метод на плащане</th>
                        <th>Фискален бон</th>
                        <th>Разписка</th>
                        <th>Сертификат</th>
                        <th>Обслужващ</th>
                        <th class="sort-false">Още</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        @include('admin.payments.item')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection