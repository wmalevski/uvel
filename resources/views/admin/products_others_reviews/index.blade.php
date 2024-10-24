@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Ревюта на Кутии/Икони</h4>
        <p>Преглед на създадените ревюта.</p>
        <table id="main_table" class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th>Снимка</th> 
                    <th>Уникален номер Кутия/Икона</th> 
                    <th>Потребител</th> 
                    <th>Заглавие</th>
                    <th>Рейтинг</th>
                    <th>Продукт</th>
                    <th data-sort-method="none">Действия</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review) 
                    @include('admin.products_others_reviews.table')
                @endforeach
            </tbody>
        </table>
        {{ $reviews->links() }}
      </div>
    </div>
</div>
@endsection
