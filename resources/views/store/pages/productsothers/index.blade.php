@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

        </div>
    </div>
</div>
<div id="content-wrapper-parent">
		<div id="content-wrapper">
			<!-- Content -->
			<div id="content" class="clearfix">
				<div id="breadcrumb" class="breadcrumb">
					<div itemprop="breadcrumb" class="container">
						<div class="row">
							<div class="col-md-24">
								{{ Breadcrumbs::render('productsothers') }}
							</div>
						</div>
					</div>
				</div>

				<section class="content">
					<div class="container">
						<div class="row">
							<div id="collection-content">
								<div id="page-header">
									<h1 id="page-title">Продукти</h1>
								</div>
								<div class="collection-warper col-sm-24 clearfix">
									<div class="collection-panner">
										<img src="./assets/images/demo_1170x420.png" class="img-responsive" alt="">
									</div>
								</div>
								<div class="collection-main-content">
										<div id="prodcoll" class="col-sm-6 col-md-6 sidebar hidden-xs">
												<div class="group_sidebar">
													<div class="sb-wrapper">
														<!-- filter tags group -->
														<div class="filter-tag-group" data-url="ajax/filter/productsothers">
															<h6 class="sb-title">Филтри</h6>
															<div class="tag-group" id="coll-filter-3">
																<p class="title">
																	Тип
																</p>
																<ul>
																	@foreach($productothertypes as $type)
																		<li><a title="Narrow selection to products matching tag Under $100" href="#"><span class="fe-checkbox"></span> {{ $type->name }} </a></li>
																	@endforeach
																</ul>
															</div>

															<div class="tag-group" id="coll-filter-3">
																<p class="title">
																	Налично в
																</p>
																<ul>
																	@foreach($stores as $store)
																		<li><a title="Narrow selection to products matching tag Under $100" href="#"><span class="fe-checkbox"></span> {{ $store->name }} ({{ count($store->products) }})</a></li>
																	@endforeach
																</ul>
															</div>
															<!-- tags groupd 3 -->


															<!-- tags groupd 3 -->
															<div class="tag-group" id="coll-filter-3">
																<p class="title">
																	Размер
																</p>
																<input type="number" class="form-control" placeholder="Въведи размер">
															</div>
															<!-- tags groupd 3 -->

															<!-- tags groupd 3 -->
															<div class="tag-group" id="coll-filter-3">
																<p class="title">
																	Цена
																</p>

																<input type="number" class="form-control" placeholder="От">
																<input type="number" class="form-control" placeholder="До">
															</div>
															<!-- tags groupd 3 -->
														</div>
													</div>

												</div><!--end group_sidebar-->
											</div>
									<div id="col-main" class="collection collection-page col-sm-18 col-md-18 no_full_width have-left-slidebar">
										<div class="container-nav clearfix">
											<div id="options" class="container-nav clearfix">
												<ul class="list-inline text-right">
													<li class="grid_list">
													<ul class="list-inline option-set hidden-xs" data-option-key="layoutMode">
														<li data-original-title="Грид" data-option-value="fitRows" id="goGrid" class="goAction btooltip active" data-toggle="tooltip" data-placement="top" title="">
														<span></span>
														</li>
														<li data-original-title="Лист" data-option-value="straightDown" id="goList" class="goAction btooltip" data-toggle="tooltip" data-placement="top" title="">
														<span></span>
														</li>
													</ul>
													</li>
													<li class="sortBy">
														<div id="sortButtonWarper" class="dropdown-toggle" data-toggle="dropdown">
															<strong class="title-6">Подреди</strong>
															<button id="sortButton">
															<span class="name">Най-нови</span><i class="fa fa-caret-down"></i>
															</button>
															<i class="sub-dropdown1"></i>
															<i class="sub-dropdown"></i>
														</div>
														<div id="sortBox" class="control-container dropdown-menu">
															<ul id="sortForm" class="list-unstyled option-set text-left list-styled" data-option-key="sortBy">
																<li class="sort" data-option-value="price" data-order="asc">Цена: Ниска към Висока</li>
																<li class="sort" data-option-value="price" data-order="desc">Цена: Висока към Ниска</li>
																<li class="sort" data-option-value="title" data-order="asc">А-Я</li>
																<li class="sort" data-option-value="title" data-order="desc">Я-А</li>
																<li class="sort" data-option-value="created" data-order="asc">Стари към нови</li>
																<li class="sort" data-option-value="created" data-order="desc">Нови към стари</li>
															</ul>
														</div>
													</li>
												</ul>
											</div>
										</div>
										<div id="sandBox-wrapper" class="group-product-item row collection-full">
											<ul id="sandBox" class="list-unstyled">
                                                @foreach($products as $product)
                                                    <li class="element first no_full_width" data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-title="{{ $product->name }}" data-created="{{ $product->id }}">
                                                        <ul class="row-container list-unstyled clearfix">
                                                            <li class="row-left">
                                                            <a href="{{ route('single_product_other', ['product' => $product->id])  }}" class="container_item">
                                                            <img src="@if($product->photos) {{ asset("uploads/products/" . $product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $product->name }}">
                                                            </a>
                                                            <div class="hbw">
                                                                <span class="hoverBorderWrapper"></span>
                                                            </div>
                                                            </li>
                                                            <li class="row-right parent-fly animMix">
                                                            <div class="product-content-left">
																<a class="title-5" href="{{ route('single_product_other', ['product' => $product->id])  }}">{{ $product->name }}</a><br/>
																No: {{ $product->code }}
                                                                <span class="spr-badge" id="spr_badge_12932382113" data-rating="0.0">
                                                                <span class="spr-starrating spr-badge-starrating">
																	@if(count($product->reviews) > 0)
																		<span class="spr-starrating spr-badge-starrating">
																			{{$product->listProductOtherAvgRatingStars($product)}}
																		</span>
																	@else
																		<span class="spr-badge-caption" style="display:block;">Няма ревюта</span>
																	@endif
																</span>
                                                                {{-- <span class="spr-badge-caption">
                                                                No reviews </span>
                                                                </span> --}}
                                                            </div>
                                                            <div class="product-content-right">
                                                                <div class="product-price">
                                                                    <span class="price">{{ $product->price }} лв</span>
                                                                </div>
                                                            </div>
                                                            <div class="list-mode-description">
																No: {{ $product->code }} <br/>

                                                            </div>
                                                            <div class="hover-appear">
                                                                <form action="#" method="post">
                                                                    <div class="effect-ajax-cart">
                                                                        <input name="quantity" value="1" type="hidden">
                                                                        <button class="select-option" type="button" onclick="window.location.href='{{ route('single_product', ['product' => $product->id])  }}'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Преглед</span></button>
                                                                    </div>
                                                                </form>
                                                                <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                    <div data-handle="curabitur-cursus-dignis" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal" data-url="productsothers/{{ $product->id }}/">
                                                                        <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Бърз преглед</span>

                                                                    </div>
                                                                </div>
                                                                <a class="wish-list" href="#" data-url="{{ route('wishlists_store', ['type' => 'product_other', 'item' => $product->id]) }}" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Добави в желани</span></a>
                                                            </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endforeach


													</ul>
												</li>
                                            </ul>
                                            {{ $products->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</section>
      </div>
    </div>
@endsection