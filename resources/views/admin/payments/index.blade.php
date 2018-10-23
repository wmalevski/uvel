@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби</h4>
            <p>Преглед на списък с продажбите.</p>
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
                        <th>Още</th>
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