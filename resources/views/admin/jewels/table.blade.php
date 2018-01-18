<tr>
    <td scope="col"></td>
    <td>{{ $jewel->name }}</td> 
    <td>{{ App\Materials::find($jewel->material)->name }}</td> 
    <td><a href="jewels/{{ $jewel->id }}"><i class="c-brown-500 ti-pencil"></i></a></td>
</tr>