<tr data-id="{{ $product->id }}">
	<td class="thumbnail--tooltip">
		@if($product->photos)
			<button class="product-information-btn" data-toggle="modal" data-target="#productInformation">
				<img class="admin-product-image" src="{{ asset("uploads/products/" . $product->photos->first()['photo']) }}">
			</button>
			<ul class="product-hover-image" style="background-image: url({{ asset("uploads/products/".$product->photos->first()['photo']) }});"></ul>
		@elseif($product->model)
			<img class="admin-product-image" src="{{ asset("uploads/models/" . $product->model->photos->first()['photo']) }}">
			<ul class="product-hover-image" style="background-image: url({{ asset("uploads/models/".$product->model->photos->first()['photo']) }});"></ul>
		@endif
	</td>
	
	<td>
		{{ $product->id }}
	</td>

	<td>
		@if($product->model) {{ $product->model->name }} @endif
	</td>
	<td>
		{{ $product->size }}
	</td>
	<td>
		{{$product->store_info->id }}
	</td>
	<td>
		@if($product->material) {{ $product->material->name }} - {{ $product->material->color}} - {{ $product->material->code}} @endif
	</td>
	<td>
		{{ $product->retailPrice->price }}
	</td>
	<td>
		{{ $product->weight }}
	</td>
	<td>
		{{ $product->price }}лв.
	</td>
	<td>
		{{ $product->workmanship }}лв.
	</td>

	<td>
		@if($product->status == 'selling')
		<span class="badge bgc-deep-purple-50 c-deep-purple-700 p-10 lh-0 tt-c badge-pill">В продажба</span>
		@elseif($product->status == 'sold')
		<span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Продаден</span>
		@elseif($product->status == 'travelling')
		<span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">На път</span>
		@elseif($product->status == 'reserved')
		<span class="badge bgc-orange-50 c-orange-700 p-10 lh-0 tt-c badge-pill">Резервиран</span>
		@else
		<span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Наличен</span> @endif</td>

	<td>
		@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['storehouse', 'admin', 'manager']))
			<span data-url="products/{{$product->id}}" class="edit-btn" data-form-type="edit" data-form="products"
				  data-toggle="modal"
				  data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span>
		@endif
		<a href="reviews/product/{{$product->id}}"><i class="c-brown-500 ti-star"></i></a>
		<a data-print-label="true" target="_blank" href="/ajax/products/generatelabel/{{$product->barcode}}"
		   class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
		@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['storehouse', 'admin', 'manager']))
			<span data-url="products/delete/{{$product->id}}" class="delete-btn"><i
						class="c-brown-500 ti-trash"></i></span>
		@endif
	</td>

</tr>
