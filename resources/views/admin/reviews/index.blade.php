@extends('admin.layout')

@section('content')

<div class="modal fade" id="editContour" tabindex="-1"  role="dialog" aria-labelledby="editContour">
    <div class="modal-dialog edit--modal_holder" role="document">
        <div class="modal-content">
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
      <div class="bgc-white bd bdrs-3 p-20 mB-20">
        <h4 class="c-grey-900 mB-20">Ревюта</h4>
        <p>Преглед на създадените ревюта.</p>
        <table class="table table-condensed tablesort">
            <thead>
                <tr>
                    <th>Потребител</th> 
                    <th>Заглавие</th>
                    <th>Рейтинг</th>
                    <th>Продукт</th>
                    <th class="sort-false">Действия</th> 
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review) 
                    @include('admin.reviews.table')
                @endforeach
            </tbody>
        </table>
      </div>
    </div>
</div>
@endsection