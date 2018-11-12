@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div id="content-wrapper-parent">
		<div id="content-wrapper">  
			<!-- Content -->
			<div id="content" class="clearfix">                
				<div id="breadcrumb" class="breadcrumb">
					<div itemprop="breadcrumb" class="container">
						<div class="row">
							<div class="col-md-24">
								<a href="./index.html" class="homepage-link" title="Back to the frontpage">Начало</a>
								<span>/</span>
								<span class="page-title">Каталог с модели</span>
							</div>
						</div>
					</div>
				</div>
                
				<section class="content">
					<div class="container">
						<div class="row"> 
							<div id="collection-content">
								<div id="page-header">
									<h1 id="page-title">Модели</h1>
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
														<div class="filter-tag-group">
															<h6 class="sb-title">Филтри</h6>
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
																		Вид бижу
																	</p>
																	<ul>
																		@foreach($jewels as $jewel)
																			<li><a title="Narrow selection to products matching tag Under $100" href="#"><span class="fe-checkbox"></span> {{ $jewel->name }} ({{ count($jewel->products) }})</a></li>
																		@endforeach
																	</ul>
																</div>
																<!-- tags groupd 3 -->

															<!-- tags groupd 3 -->
															<div class="tag-group" id="coll-filter-3">
																<p class="title">
																	Материал
																</p>
																<ul>
																	@foreach($materials as $material)
																		<li><a title="Narrow selection to products matching tag Under $100" href="#"><span class="fe-checkbox"></span> {{ $material->name }} ({{ count($material->products) }})</a></li>
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
														<span class="name">Featured</span><i class="fa fa-caret-down"></i>
														</button>
														<i class="sub-dropdown1"></i>
														<i class="sub-dropdown"></i>
													</div>
													<div id="sortBox" class="control-container dropdown-menu">
														<ul id="sortForm" class="list-unstyled option-set text-left list-styled" data-option-key="sortBy">
															<li class="sort" data-option-value="manual">Featured</li>
															<li class="sort" data-option-value="price-ascending" data-order="asc">Price: Low to High</li>
															<li class="sort" data-option-value="price-descending" data-order="desc">Price: High to Low</li>
															<li class="sort" data-option-value="title-ascending" data-order="asc">A-Z</li>
															<li class="sort" data-option-value="title-descending" data-order="desc">Z-A</li>
															<li class="sort" data-option-value="created-ascending" data-order="asc">Oldest to Newest</li>
															<li class="sort" data-option-value="created-descending" data-order="desc">Newest to Oldest</li>
															<li class="sort" data-option-value="best-selling">Best Selling</li>
														</ul>
													</div>
													</li>
												</ul>
											</div>
										</div>
										<div id="sandBox-wrapper" class="group-product-item row collection-full">
											<ul id="sandBox" class="list-unstyled">
												@foreach($models as $model)
                                                    <li class="element first no_full_width" data-alpha="{{ $model->name }}" data-price="{{ $model->price }}">
                                                        <ul class="row-container list-unstyled clearfix">
                                                            <li class="row-left">
                                                            <a href="{{ route('single_model', ['model' => $model->id])  }}" class="container_item">
                                                            <img src="@if($model->photos) {{ asset("uploads/models/" . $model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $model->name }}">
                                                            </a>
                                                            <div class="hbw">
                                                                <span class="hoverBorderWrapper"></span>
                                                            </div>
                                                            </li>
                                                            <li class="row-right parent-fly animMix">
                                                            <div class="product-content-left">
                                                                <a class="title-5" href="{{ route('single_model', ['model' => $model->id])  }}">{{ $model->name }}</a>
                                                                <span class="spr-badge" id="spr_badge_12932382113" data-rating="{{$model->getSimilarModelAvgRating($model)}}">
																@if(count($model->reviews) > 0)
																	<span class="spr-starrating spr-badge-starrating">
																		{{$model->listSimilarModelAvgRatingStars($model)}}
																	</span>
																@else
																	<span class="spr-badge-caption" style="display:block;">No reviews</span>
																@endif
																</span>		
                                                            </div>
                                                            <div class="product-content-right">
                                                                <div class="product-price">
                                                                    <span class="price">{{ $model->price }} лв</span>
                                                                </div>
                                                            </div>
                                                            <div class="list-mode-description">
																 Модел: {{ $model->name }} <br/>
																 Бижу: {{ $model->jewel->name }} <br/>
																 Размер: {{ $model->size }}
                                                            </div>
                                                            <div class="hover-appear">
                                                                <form action="#" method="post">
                                                                    <div class="effect-ajax-cart">
                                                                        <input name="quantity" value="1" type="hidden">
                                                                        <button class="select-option" type="button" onclick="window.location.href='{{ route('single_model', ['model' => $model->id])  }}'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Преглед</span></button>
                                                                    </div>
                                                                </form>
                                                                <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                    <div data-handle="curabitur-cursus-dignis" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal" data-barcode="{{ $model->barcode }}">
                                                                        <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Бърз преглед</span>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                @endforeach
												
												
													</ul>
												</li>												
                                            </ul>
                                            {{ $models->links() }}
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