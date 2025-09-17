@extends('store.layouts.app', ['bodyClass' => 'templateWishlist'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
					<div itemprop="breadcrumb" class="container">
							<div class="row">
									<div class="col-md-24">
											{{ Breadcrumbs::render('wishlist') }}
									</div>
							</div>
					</div>
			</div>
			<div class="container">
				<div id="page-header" class="col-md-24">
					<h1 id="page-title">Запазени продукти</h1>
				</div>
				<div id="col-main" class="col-md-24 clearfix">
					<div class="page page-wishlist">
						@foreach($wishList as $wishListItem)
						<div class="wishlist-item">

							<div class="image-container">
								<a href="{{$wishListItem->checkWishListItemType($wishListItem)['url']}}">
									@if ($wishListItem->product_id)
										@php
											$productPhotos = $wishListItem->product->photos;
											$hasProductPhoto = $productPhotos && $productPhotos->first() && isset($productPhotos->first()['photo']);
										@endphp
										@if($hasProductPhoto)
											<img class="img-fill img-responsive" src="{{ getPhoto('products/' . $productPhotos->first()['photo']) }}" alt="{{ $wishListItem->product->name }}">
										@else
											<div class="img-fill" style="display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; color: #666; text-align: center; padding: 20px;">
												Снимката не е налична
											</div>
										@endif
									@elseif ($wishListItem->model_id)
										@php
											$modelPhotos = $wishListItem->model->photos;
											$hasModelPhoto = $modelPhotos && $modelPhotos->first() && isset($modelPhotos->first()['photo']);
										@endphp
										@if($hasModelPhoto)
											<img class="img-fill img-responsive" src="{{ getPhoto('models/' . $modelPhotos->first()['photo']) }}" alt="{{ $wishListItem->model->name }}">
										@else
											<div class="img-fill" style="display: flex; align-items: center; justify-content: center; background-color: #f5f5f5; color: #666; text-align: center; padding: 20px;">
												Снимката не е налична
											</div>
										@endif
									@endif
								</a>
							</div>

							<div class="link">
								<p>
									<a href="{{$wishListItem->checkWishListItemType($wishListItem)['url']}}">
										{{$wishListItem->checkWishListItemType($wishListItem)['item']->name}}
									</a>
								</p>
							</div>

							<div class="price">
								<p>{{$wishListItem->checkWishListItemType($wishListItem)['item']->price}} лв.</p>
							</div>

							<div class="remove">
								<p>
									<a href="wishlist/delete/{{$wishListItem->id}}" class="delete-btn">
										<i class="fa fa-times"></i>
									</a>
								</p>
							</div>

						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
