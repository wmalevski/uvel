@extends('admin.layout')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="bgc-white bd bdrs-3 p-20 mB-20">
      <h4 class="c-grey-900 mB-20">Блог коментари</h4>
      <p>Преглед на коментарите.</p>
      <table class="table">
        <thead>
          <tr>
            <th scope="col">Коментар</th> 
            <th scope="col">Потребител</th> 
            <th scope="col">Дата</th> 
            <th scope="col">Действия</th>
          </tr>
        </thead>
        <tbody>
            @foreach($comments as $comment)
                @include('admin.blog.comments.table')
            @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection
