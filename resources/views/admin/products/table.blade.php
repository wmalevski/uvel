<tr data-id="{{ $product->id }}">
	<td class="thumbnail--tooltip">
		@if($product->photos)
			@php
				$prodPhoto=$product->photos->first();
				$prodPhoto=($prodPhoto && isset($prodPhoto['photo'])?$prodPhoto['photo']:null);
			@endphp
			<button class="product-information-btn" data-form="" data-toggle="modal" data-target="#productInformation">
				@if($prodPhoto)
				<img class="admin-product-image" src="{{ asset("uploads/products/".$prodPhoto) }}">
				@endif
			</button>
			<ul class="product-hover-image" style="
			@if($prodPhoto)
				background-image: url({{ asset("uploads/products/".$prodPhoto) }});
			@endif
			"></ul>
		@elseif($product->model)
			@php
				$modPhoto=$product->model->photos->first();
				$modPhoto=($modPhoto && isset($modPhoto['photo'])?$modPhoto['photo']:null);
			@endphp
			@if($modPhoto)
			<img class="admin-product-image" src="{{ asset("uploads/models/".$modPhoto) }}">
			@endif
			<ul class="product-hover-image" style="
			@if($modPhoto)
			background-image: url({{ asset("uploads/models/".$modPhoto) }});
			@endif
			"></ul>
		@endif
	</td>

	<td>{{$product->id}}</td>
	<td>@if($product->model) {{$product->model->name}} @endif</td>
	<td>{{$product->size}}</td>
	<td>{{$product->store_info->id}}</td>
	<td>@if($product->material) {{$product->material->name}} - {{$product->material->color}} - {{$product->material->code}} @endif</td>
	<td>{{$product->retailPrice->price}}</td>
	<td>@if($product->weight_without_stones == 'yes')
      {{$product->weight}}
    @else
      {{$product->gross_weight}}
    @endif</td>
	<td>{{$product->price}}лв.</td>
	<td>{{$product->workmanship}}лв.</td>
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
		<span class="badge bgc-green-50 c-green-700 p-10 lh-0 tt-c badge-pill">Наличен</span> @endif
	</td>
	<td>@if(in_array(\Illuminate\Support\Facades\Auth::user()->role, ['admin', 'storehouse', 'manager']))
		<span data-url="products/{{$product->id}}" class="edit-btn" data-form-type="edit" data-form="products" data-toggle="modal" data-target="#editProduct"><i class="c-brown-500 ti-pencil"></i></span>
	@endif
		<a href="reviews/product/{{$product->id}}"><i class="c-brown-500 ti-star"></i></a>
		<a data-print-label="true" target="_blank" href="/ajax/products/generatelabel/{{$product->barcode}}" class="print-btn"><i class="c-brown-500 ti-printer"></i></a>
		@if(\Illuminate\Support\Facades\Auth::user()->role == 'admin')
			<span data-url="products/delete/{{$product->id}}" class="delete-btn"><i class="c-brown-500 ti-trash"></i></span>
		@endif
	</td>
</tr>