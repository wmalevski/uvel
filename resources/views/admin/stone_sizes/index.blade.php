@extends('admin.layout')

@section('content')
    <h3>Размери Камъни</h3>

    <form method="POST" class="form-inline" action="">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="1">Име: </label>
            <input type="text" class="form-control" id="1" name="name" placeholder="Вид/Име:">
        </div>

        <button type="submit" class="btn btn-default">Добави</button>
    </form>

    @foreach ($errors->all() as $message)
        {{ $message }}
    @endforeach

    <h3>Преглед на материали</h3>
    
    <table class="table table-condensed">
        <tr>
            <th>#</th>
            <th>Име</th> 
        </tr>
        
        @foreach($sizes as $size)
            <tr>
                <td></td>
                <td>{{ $size->name }}</td> 
            </tr>
        @endforeach
    </table>
@endsection