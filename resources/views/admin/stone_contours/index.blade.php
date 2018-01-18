@extends('admin.layout')

@section('content')
<h3>Контури Камъни</h3>

<form method="POST" class="form-inline" action="">
    {{ csrf_field() }}

    <div class="form-group">
        <label for="1">Име: </label>
        <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
    </div>

    <button type="submit" class="btn btn-default">Добави</button>
</form>

@foreach ($errors->all() as $message)
    <div class="bg-danger"> {{ $message }} </div>
@endforeach

<h3>Преглед на контури</h3>

<table class="table table-condensed">
    <tr>
        <th>#</th>
        <th>Име</th> 
    </tr>
    
    @foreach($contours as $contour)
        <tr>
            <td></td>
            <td>{{ $contour->name }}</td> 
        </tr>
    @endforeach
</table>
@endsection