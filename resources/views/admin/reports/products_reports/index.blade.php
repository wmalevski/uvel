@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20">
                <h4 class="c-grey-900 mB-20"> Продукти </h4>
                <p>Преглед на продуктите.</p>
                <table id="main_table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">Модел</th>
                        <th scope="col">Материал</th>
                        @foreach($stores as $store)
                            <th scope="col">{{ $store->name }}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                       @include('admin.reports.products_reports.table')
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
