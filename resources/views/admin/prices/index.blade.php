@extends('admin.layout')

@section('content')

<h3>Изберете материал</h3>
    
<form method="POST" class="form-inline" action="">
    {{ csrf_field() }}

    <select name="material" class="form-control">
        <option value="">Избери</option> 
           
        @foreach($materials as $material)
            <option value="{{ $material->id }}">{{ $material->name }} - {{ $material->code }}</option>
        @endforeach
    </select>

    <button type="submit" class="btn btn-default">Покажи цени</button>
</form>
@endsection