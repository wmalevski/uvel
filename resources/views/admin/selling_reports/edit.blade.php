@extends('admin.layout')

@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Експорт </h4>
                <p>Преглед на продажби в <strong>{{ $store->name }} - {{ $store->location }}</strong>.</p>
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Артикул</th>
                        <th scope="col">Продажба</th>
                        <th scope="col">Стойност</th>
                        <th scope="col">Отстъпка</th>
                        <th scope="col">След отстъпка</th>
                        <th scope="col">С карта/кеш</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Служител</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($payments as $payment)
                            @foreach($products as $product)
                                @if($product->id == $payment->product_id)
                                    @include('admin.selling_reports.table_edit')
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection