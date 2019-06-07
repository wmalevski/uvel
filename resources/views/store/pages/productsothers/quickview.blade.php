<div class="quickview-modal-wrapper">
	<div class="modal-header">
		<i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="" data-dismiss="modal"
		 aria-hidden="true" data-original-title="Close"></i>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 product-image">
				<div id="quick-shop-image" class="product-image-wrapper">
					<a class="main-image">
						<img alt="{{ $product->name }}" class="img-zoom img-responsive image-fly"
							src="@if(App\Gallery::where('product_other_id',$product->id)->get()){{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $product->id)->first()->photo) }}@endif">
					</a>
					<div id="gallery_main_qs" class="product-image-thumb">
						@if(App\Gallery::where('product_other_id', $product->id)->first()->get())
							@foreach(App\Gallery::where('product_other_id', $product->id)->get() as $data)
							<a class="image-thumb active" href="{{ asset("uploads/products_others/" . $data->photo) }}" data-image="{{ asset("uploads/products_others/" . $data->photo) }}"
							data-zoom-image="{{ asset("uploads/products_others/" . $data->photo) }}">
							<img src="{{ asset("uploads/products_others/" . $data->photo) }}" alt="{{ $product->name }}" /></a>
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-12 product-information">
				<h1 id="quick-shop-title">
					<span>
						<a href="{{ route('single_product_other', ['product' => $product->id])  }}">
							{{ $product->name }}
						</a>
					</span>
				</h1>
				<div id="quick-shop-infomation" class="description">
					<div id="quick-shop-description" class="text-left">
						<p>
							No: {{ $product->code }}
						</p>
					</div>
				</div>
				<div id="quick-shop-container">
					<div id="quick-shop-price-container" class="detail-price">
						<span class="price_sale">
							{{ number_format($product->price) }} лв.
						</span>
					</div>

					<div class="quantity-wrapper clearfix">
						<label class="wrapper-title">
							Количество
						</label>
						<div class="wrapper">
							<input type="text" id="qs-quantity" size="5" class="item-quantity" name="quantity" value="1">
							<span class="qty-group">
								<span class="qty-wrapper">
									<span class="qty-up" title="Increase" data-src="#qs-quantity">
										<i class="fa fa-plus"></i>
									</span>
									<span class="qty-down" title="Decrease" data-src="#qs-quantity">
										<i class="fa fa-minus"></i>
									</span>
								</span>
							</span>
						</div>
					</div>

					<div class="others-bottom">
						<button id="quick-shop-add" class="btn small add-to-cart productsothers" type="submit" data-url="{{ route('CartAddItem', ['item' => $product->barcode, 'quantity' => '']) }}">
							Добави в количката
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
