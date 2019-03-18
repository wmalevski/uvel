@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')
<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>
<div id="content-wrapper-parent" class="store-page-models">
	<div id="content-wrapper">
		<!-- Content -->
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('model_orders') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="collection-content">
							<div id="page-header">
								<h1 id="page-title">Модели по поръчка</h1>
							</div>
							<div class="collection-main-content">
								<div id="prodcoll" class="col-sm-6 col-md-6 sidebar hidden-xs">
									<div class="group_sidebar">
										<div class="sb-wrapper">
											<!-- filter tags group -->
											<div class="filter-tag-group" data-url="ajax/filter/models">
												<h6 class="sb-title">Филтри</h6>

												<div class="tag-group" id="coll-filter-3">
													<p class="title">Вид бижу</p>
													<ul>
														@foreach($jewels as $jewel)
														<li>
															<a href="#" data-id="byJewel[]={{ $jewel->id }}">
																<span class="fe-checkbox"></span>
																{{ $jewel->name }} ({{ count($jewel->models) }})
															</a>
														</li>
														@endforeach
													</ul>
												</div>

												<div class="tag-group" id="coll-filter-3">
													<p class="title">Цена</p>
													<input type="number" class="form-control" placeholder="От" data-id="priceFrom[]=">
													<input type="number" class="form-control" placeholder="До" data-id="priceTo[]=">
												</div>
											</div>
										</div>

									</div>
									<!--end group_sidebar-->
								</div>
								<div id="col-main" class="collection collection-page col-sm-18 col-md-18 no_full_width have-left-slidebar">
									<div class="container-nav clearfix">
										<div id="options" class="container-nav clearfix">
											<ul class="list-inline text-right">
												<li class="grid_list">
													<ul class="list-inline option-set hidden-xs" data-option-key="layoutMode">
														<li data-original-title="Грид" data-option-value="fitRows" id="goGrid" class="goAction btooltip active"
														 data-toggle="tooltip" data-placement="top" title="">
															<span></span>
														</li>
														<li data-original-title="Лист" data-option-value="straightDown" id="goList" class="goAction btooltip"
														 data-toggle="tooltip" data-placement="top" title="">
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
											@foreach($models as $model)
											<li class="element no_full_width"
													data-alpha="{{ $model->name }}" data-price="{{ $model->price }}" data-id="{{ $model->id }}">
												<ul class="row-container list-unstyled clearfix">
													<li class="row-left">
														<a href="{{ route('single_model', ['model' => $model->id])  }}" class="container_item">
															<img src="@if($model->photos) {{ asset("uploads/models/" . $model->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif"
															 class="img-fill" alt="{{ $model->name }}">
														</a>
														<div class="hbw hidden-xs hidden-sm">
															<span class="hoverBorderWrapper"></span>
														</div>
													</li>
													<li class="row-right parent-fly animMix">
														<div class="product-content-left">
															<a class="title-5" href="{{ route('single_model', ['model' => $model->id])  }}">
															{{ $model->name }}
															</a>
															<br/>
															{{ $model->weight }}гр.
															<br>
															<strong class="text-danger">По Поръчка за 10 дни</strong>
															<span class="spr-badge" data-rating="{{$model->getModelAvgRating($model)}}">
																<span class="spr-starrating spr-badge-starrating">
																	{{$model->listModelAvgRatingStars($model)}}
																</span>
															</span>
														</div>
														<div class="product-content-right">
															<div class="product-price">
																<span class="price">{{ number_format($model->price) }} лв</span>
															</div>
														</div>

														<div class="hover-appear hidden-xs hidden-sm">
															<a href="{{ route('single_model', ['model' => $model->id]) }}" title="Преглед" class="effect-ajax-cart product-ajax-qs">
																<input name="quantity" value="1" type="hidden">
																<i class="fa fa-lg fa-th-list"></i>
																<span class="list-mode">Преглед</span>
															</a>
															
															<button class="product-ajax-qs hidden-xs hidden-sm quick_shop" data-target="#quick-shop-modal" data-toggle="modal"
																 			data-url="models/{{ $model->id }}/" title="Бърз Преглед">
																<i class="fa fa-lg fa-eye"></i>
																<span class="list-mode">Бърз преглед</span>
															</button>
														</div>
														
													</li>
												</ul>
											</li>
											@endforeach
										</ul>
										<!-- Paginator -->
										{{ $models->appends(Illuminate\Support\Facades\Input::except('page'))->links() }}
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
@endsection
