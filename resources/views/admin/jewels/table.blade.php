<tr>
    <td scope="col"></td>
    <td>{{ $jewel->name }}</td> 
    <td>{{ App\Materials::find($jewel->material)->name }}</td> 
    <td><a href="jewels/{{ $jewel->id }}"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a></td>
</tr>