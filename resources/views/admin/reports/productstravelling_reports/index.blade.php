@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Продукти на път </h4>
                <p>Преглед на продуктите на път.</p>
                <table id="main_table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">Артикул</th>
                        <th scope="col">ОТ Магазин</th>
                        <th scope="col">Изпратен Дата/Час</th>
                        <th scope="col">Служител</th>
                        <th scope="col">ДО Магазин</th>
                        <th scope="col">Приет Дата/Час</th>
                        <th scope="col">Служител</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products_travellings as $products_travelling)
                        @include('admin.reports.productstravelling_reports.table')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
