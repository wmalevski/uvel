@extends('admin.layout')

@section('content')
<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Ревюта</h4>
        <p>Преглед на създадените ревюта.</p>
        <table class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th>Снимка</th>
                    <th>Уникален номер артикул</th>
                    <th>Артикул тип</th>
                    <th>Потребител</th> 
                    <th>Заглавие</th>
                    <th>Рейтинг</th>
                    <th>Продукт</th>
                    <th data-sort-method="none">Действия</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review) 
                    @include('admin.reviews.table')
                @endforeach
            </tbody>
        </table>
      </div>
      {{ $reviews->links() }}
    </div>
</div>
@endsection
