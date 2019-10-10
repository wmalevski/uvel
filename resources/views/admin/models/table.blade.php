<tr data-id="{{ $model->id }}">
	<td class="thumbnail--tooltip">
		@if(count($model->photos))
			<img class="admin-product-image" src="{{ asset("uploads/models/" . $model->photos->first()['photo']) }}">
			<ul  class="product-hover-image" style="background-image: url({{ asset("uploads/models/" . $model->photos->first()['photo']) }});" ></ul>
		@endif
	</td>
	<td>{{ $model->name }}</td>
	<td>
		{{ $model->weight }}
	</td>
	<td>
		{{ $model->price }}лв.
	</td>
	<td>
		{{ $model->workmanship }}лв.
	</td>
	<td>
		<span data-url="models/{{$model->id}}" class="edit-btn" data-form-type="edit" data-form="models" data-toggle="modal"
		 data-target="#editModel">
			 <i class="c-brown-500 ti-pencil"></i>
		</span>
		<span data-url="models/delete/{{$model->id}}" class="delete-btn">
			<i class="c-brown-500 ti-trash"></i>
		</span>
	</td>

	<td class="stones--tooltip">
		Виж камъни
		<ul>
			@if(!empty($model->stones->first()))
				@foreach($model->stones as $stone)
				<li>
					Име: {{$stone->stone->nomenclature->name }} - {{$stone->stone->contour->name }} - {{$stone->stone->size->name }} , Количество: {{ $stone->amount }}
				</li>
				@endforeach
			@else
			<li>
				Няма налични камъни.
			</li>
			@endif
		</ul>
	</td>
</tr>

