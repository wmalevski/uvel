<div class="quickview-modal-wrapper">
	<div class="modal-header">
		<i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="Затвори" data-dismiss="modal" aria-hidden="true"></i>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 product-image">
				<div id="quick-shop-image" class="product-image-wrapper">
					<a class="main-image">
						<img class="img-zoom img-responsive image-fly" alt="{{ $model->name }}"
						 src="@if($model->photos){{ asset("uploads/models/" . $model->photos->first()['photo']) }}@endif"/>
					</a>

					<div id="gallery_main_qs" class="product-image-thumb">
						@if($model->photos)
						@foreach($model->photos as $image)
						<a class="image-thumb active" href="{{ asset("uploads/models/" . $image->photo) }}" data-image="{{ asset("uploads/models/" . $image->photo) }}"
						 data-zoom-image="{{ asset("uploads/models/" . $image->photo) }}">
						 <img src="{{ asset("uploads/models/" . $image->photo) }}" alt="{{ $model->name }}" /></a>
						@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-md-12 product-information">
				<h1 id="quick-shop-title">
					<span>
						<a href="{{ route('single_model', ['model' => $model->id])  }}">
							{{ $model->name }}
						</a>
					</span>
				</h1>
				<div id="quick-shop-infomation" class="description">
					<div id="quick-shop-description" class="text-left">
						<p>
							No: {{ $model->code }}
							<br/>
							{{ $model->weight }}гр.
							<br/>
						</p>
					</div>
				</div>
				<div id="quick-shop-container">
					<div id="quick-shop-price-container" class="detail-price">
						<span class="price_sale">
							{{ $model->price }}лв.
						</span>
						<span class="dash"></span>
						{{-- <del class="price_compare">$300.00</del> --}}
					</div>
					<div class="others-bottom">
						<a data-url="{{ route('order_model', ['model' => $model->id]) }}" class="order_product btn btn-1">
							Поръчай
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
