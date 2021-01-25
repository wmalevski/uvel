<div class="quickview-modal-wrapper">
	<div class="modal-header">
		<i class="close fa fa-times btooltip" data-toggle="tooltip" data-placement="top" title="Затвори" data-dismiss="modal" aria-hidden="true"></i>
	</div>
	<div class="modal-body">
		<div class="row">
			<div class="col-md-12 product-image">
				<div id="quick-shop-image" class="product-image-wrapper">
					<a class="main-image" href="{{ route('single_model', ['model' => $model->id])  }}">
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
							Модел: {{ $model->name }}
							<br/>
							{{ $model->weight }}гр.
							<br/>
							<strong class="text-danger">По Поръчка за 10 дни</strong>
							<br/>
						</p>
					</div>
				</div>
				<div id="quick-shop-container">
					<div id="quick-shop-price-container" class="detail-price">
						<span class="price_sale">
							{{ number_format($model->price) }} лв.
						</span>
						<span class="dash"></span>
					</div>
					<div class="others-bottom">
						<button id="quick-shop-add" class="btn small add-to-cart" type="submit" data-url="{{ route('CartAddItem', ['item' => $model->barcode, 'quantity' => 1]) }}">Добави в количката</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
