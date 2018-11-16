@extends('admin.layout')

@section('content')

<div class="modal fade edit--modal_holder" id="editPayment" role="dialog" aria-labelledby="editPaymentLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Продажби</h4>
            <p>Преглед на списък с продажбите.</p>
            <table class="table table-condensed tablesort">
                <thead>
                    <tr>
                        <th>Потребител</th>
                        <th>Метод на доставка</th>
                        <th>Метод на плащане</th>
                        <th>Цена</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sellings as $selling)
                        @include('admin.selling.online.table')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection