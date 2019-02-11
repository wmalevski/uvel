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
						@if(session()->has('success.wishlist'))
							<div class="alert alert-success">
									{{ session()->get('success.wishlist') }}
							</div>
						@endif

						@foreach($wishList as $wishListItem)
						<div class="wishlist-item">

							<div class="image-container">
								<a href="{{$wishListItem->checkWishListItemType($wishListItem)['url']}}">
									@if ($wishListItem->product_id)
										<img class="img-fill" src="@if($wishListItem->product->photos) {{ asset("uploads/products/" . $wishListItem->product->photos->first()['photo']) }}
									@else {{ asset('store/images/demo_375x375.png') }}
									@endif"
									class="img-responsive" alt="{{ $wishListItem->product->name }}">
									@elseif ($wishListItem->model_id)
										<img class="img-fill" src="@if($wishListItem->model->photos) {{ asset("uploads/models/" . $wishListItem->model->photos->first()['photo']) }}
									@else {{ asset('store/images/demo_375x375.png') }}
									@endif" class="img-responsive" alt="{{ $wishListItem->model->name }}">
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