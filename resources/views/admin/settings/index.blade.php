@extends('admin.layout')

@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="bgc-white bd bdrs-3 p-20 mB-20">
            <h4 class="c-grey-900 mB-20">Настройки </h4>
            Борсови цени
            <form method="POST">
                @foreach($materials as $material)
                    {{ $material->carat }}
                @endforeach
            </form>
        </div>
    </div>
</div>

@endsection