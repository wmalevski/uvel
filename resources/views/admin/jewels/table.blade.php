<tr>
    <td scope="col"></td>
    <td>{{ $jewel->name }}</td> 
    <td>{{ App\Materials::find($jewel->material)->name }} - {{ App\Materials::find($jewel->material)->color }} - {{ App\Materials::find($jewel->material)->code }}</td> 
    <td><a href="jewels/{{$jewel->id}}" class="edit-btn" data-toggle="modal" data-target="#editJewel"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>