@extends('layouts.shop')
@section('aimeos_scripts')
@parent
<script type="text/javascript" src="<?php echo asset('packages/aimeos/shop/themes/aimeos-detail.js'); ?>"></script>
@stop


@section('content')
Adding Nomenclatures

<form method="POST" action="">
    {{ csrf_field() }}

    <label>
        Name:
        <input type="text" name="name" placeholder="Enter a value:">
    </label>

    <label>
        Code:
        <input type="text" name="code" placeholder="585">
    </label>

    <label>
        Color:
        <input type="text" name="color" placeholder="Enter a value:">
    </label>

        <input type="submit" value="Add Nomenclatur">
</form>

@foreach ($errors->all() as $message)
    <div class="bg-danger"> {{ $message }} </div>
@endforeach

<table style="width:100%">
    <tr>
        <th>#</th>
        <th>Name</th> 
        <th>Code</th> 
        <th>Color</th> 
    </tr>
    
    @foreach($nomenclatures as $nomenclatur)
        <tr>
            <td></td>
            <td>{{ $nomenclatur->name }}</td> 
            <td>{{ $nomenclatur->code }}</td> 
            <td>{{ $nomenclatur->color }}</td> 
        </tr>
    @endforeach
</table>
@endsection