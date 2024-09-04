@extends('admin.layout')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="bgc-white bd bdrs-3 p-20 mB-20 table-responsive">
                <h4 class="c-grey-900 mB-20"> Продукти </h4>
                <p>Преглед на продуктите.</p>
                <table id="main_table" class="table">
                    <thead>
                    <tr>
                        <th scope="col">Материал</th>
                        @foreach($stores as $store)
                            <th scope="col">{{ $store->name }} - {{ $store->location }}</th>
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
            {{ $products->links() }}
        </div>
    </div>
@endsection
