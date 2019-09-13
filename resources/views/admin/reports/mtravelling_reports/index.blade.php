@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Материали на път </h4>
                <p>Преглед на материалите на път.</p>
                <table id="main_table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">Материал</th>
                        <th scope="col">Количество</th>
                        <th scope="col">ОТ Магазин</th>
                        <th scope="col">Изпратен Дата/Час</th>
                        <th scope="col">Служител</th>
                        <th scope="col">ДО Магазин</th>
                        <th scope="col">Приет Дата/Час</th>
                        <th scope="col">Служител</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($materials_travellings as $materials_travelling)
                        @include('admin.reports.mtravelling_reports.table')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
