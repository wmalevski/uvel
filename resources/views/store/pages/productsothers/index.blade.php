@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">{{ Breadcrumbs::render('productsothers') }}</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="collection-content">
							<div id="page-header"><h1 id="page-title">Продукти</h1></div>
							<div class="collection-main-content">
								<div id="prodcoll" class="col-sm-6 col-md-6 sidebar hidden-xs">
									<div class="group_sidebar">
										<div class="sb-wrapper">
											<div class="filter-tag-group" data-url="online/productsothers">
												<h6 class="sb-title">Филтри</h6>
												<div id="coll-filter-3" class="tag-group">
													<p class="title">Тип</p>
													<ul>
														@foreach($productothertypes as $type)
														<li class="{{ filter_products('byType', $type->id) }}">
															<a data-id="byType[]={{ $type->id }}" href="#">
																<span class="fe-checkbox"></span>
																{{ $type->name }}
															</a>
														</li>
														@endforeach
													</ul>
												</div>
												<div class="tag-group" id="coll-filter-3">
													<p class="title">Налично в</p>
													<ul>{!! StoreNav::storeFilters() !!}</ul>
												</div>
												<div class="tag-group" id="coll-filter-3">
													<p class="title">Размер</p>
													<input type="number" class="form-control" placeholder="Въведи размер">
												</div>
												<div class="tag-group" id="coll-filter-3">
													<p class="title">Цена</p>
													<input type="number" class="form-control {{isset($_GET['priceFrom'][0]) ? 'selected' : ''}}" placeholder="От" data-id="priceFrom[]=" value="{{isset($_GET['priceFrom'][0]) ? $_GET['priceFrom'][0] : ''}}" min=1 />
													<input type="number" class="form-control {{ isset($_GET['priceTo'][0]) ? 'selected' : '' }}" placeholder="До" data-id="priceTo[]=" value="{{isset($_GET['priceTo'][0]) ? $_GET['priceTo'][0] : ''}}" min=1 />
													<a href="#" id="resetPriceFilters">Изчисти ценови филтър</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div id="col-main" class="collection collection-page col-sm-18 col-md-18 no_full_width have-left-slidebar">
									<div class="container-nav clearfix">
										<div id="options" class="container-nav clearfix">
											<ul class="list-inline text-right">
												<li class="grid_list">
												</li>
												<li class="sortBy">
													<div id="sortButtonWarper" class="dropdown-toggle" data-toggle="dropdown">
														<strong class="title-6">Подреди</strong>
														<button id="sortButton">
															<span class="name">Най-нови</span>
															<i class="fa fa-caret-down"></i>
														</button>
														<i class="sub-dropdown1"></i>
														<i class="sub-dropdown"></i>
													</div>
													<div id="sortBox" class="control-container dropdown-menu">
														<ul id="sortForm" class="list-unstyled option-set text-left list-styled" data-option-key="sortBy">
															<li class="sort" data-option-value="price" data-order="asc">Цена: Ниска към Висока</li>
															<li class="sort" data-option-value="price" data-order="desc">Цена: Висока към Ниска</li>
															<li class="sort" data-option-value="name" data-order="asc">А-Я</li>
															<li class="sort" data-option-value="name" data-order="desc">Я-А</li>
															<li class="sort" data-option-value="created_at" data-order="asc">Стари към нови</li>
															<li class="sort" data-option-value="created_at" data-order="desc">Нови към стари</li>
														</ul>
													</div>
												</li>
											</ul>
										</div>
									</div>
									<div id="sandBox-wrapper" class="group-product-item row collection-full">
										<ul id="sandBox" class="list-unstyled">
											@foreach($products as $product)
											<li class="element no_full_width" data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{ $product->id }}">
												<ul class="row-container list-unstyled clearfix">
													<li class="row-left">
														<a href="{{ route('single_product_other', ['product' => $product->id])  }}" class="container_item">
															<img src="@if(App\Gallery::where('product_other_id',$product->id)->get()) {{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $product->id)->first()->photo) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-fill" alt="{{ $product->name }}" />
														</a>
														<div class="hbw"><span class="hoverBorderWrapper"></span></div>
													</li>
													<li class="row-right parent-fly animMix">
														<div class="product-content-left">
															<a class="title-5" href="{{ route('single_product_other', ['product' => $product->id]) }}">Модел: {{ $product->name }}</a>
															<br />
															No: {{ $product->id }}
															<br />
															Налично в: {{ App\Store::where('id',$product->store_id)->first()->name }}
															<span class="spr-badge">
																<span class="spr-starrating spr-badge-starrating">{{$product->listProductOtherAvgRatingStars($product)}}</span>
															</span>
														</div>
														<div class="product-content-right">
															<div class="product-price">
																<span class="price">{{ number_format($product->price) }} лв.</span>
															</div>
														</div>

														<div class="hover-appear">
															<a href="{{ route('single_product_other', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
																<input name="quantity" value="1" type="hidden">
																<i class="fa fa-lg fa-eye"></i>
																<span class="list-mode">Преглед</span>
															</a>
															@auth
															<button class="wish-list" title="Добави в желани" data-url="{{ route('wishlists_store', ['type' => 'product_other', 'item' => $product->id]) }}">
																<i class="fa fa-lg fa-heart"></i>
																<span class="list-mode">Добави в желани</span>
															</button>
															@endauth
														</div>
													</li>
												</ul>
											</li>
											@endforeach
										</ul>
										@if(count($products) == 0)
										<div class="product-content-left">Няма бижу по зададените критерии</div>
										@endif
										{{ $products->appends(request()->except('page'))->links() }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<style>
a#resetPriceFilters,a#resetPriceFilters:visited{
    font-size: 0.9em;
    color: #a67825;
    margin-left: 8%;
}
a#resetPriceFilters:hover, a#resetPriceFilters:active{
	text-decoration:underline;
}
</style>
<script type="text/javascript">
	$('body').on('click','a#resetPriceFilters',function(e){
		e.preventDefault();
		$('input[data-id="priceTo[]="],input[data-id="priceFrom[]="]').val('').change();
	});
</script>
@endsection
