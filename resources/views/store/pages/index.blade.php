@extends('store.layouts.app', ['bodyClass' => 'templateIndex'])

@section('content')
<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal"
 aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content"></div>
	</div>
</div>
<div id="content-wrapper-parent" class="home-page">
	<div id="content-wrapper">
		<form name="headerSearch" id="headerSearch" method="POST">
			<div class="row" id="homeSearch" style="background-image:url('{{ App\Setting::get('website_header') }}');">
				<div class='searchBox'>
					<div><input name="search_term" type="text" placeholder="Намери продукт" class="form-control" /></div>
					<button id="searchButton" class="btn btn-1" type="submit">ТЪРСИ</button>
				</div>
			</div>
		</form>

		<!-- Content -->
		<div id="content" class="clearfix">
			<section class="content">
				<div id="col-main" class="clearfix">
					<div class="home-popular-collections">
						<div class="container">
							<div class="group_home_collections row">
								<div class="col-md-24">
									<div class="home_collections">
										<h6 class="general-title">Популярни</h6>
										<div class="home_collections_wrapper">
											<div id="home_collections">
												@foreach($materialTypes as $material)
												<div class="home_collections_item">
													<div class="home_collections_item_inner">
														<div class="collection-details">
															<a href="online/products/?byMaterial[]={{ $material->id }}">
																<img class="img-fill" alt="{{ $material->name }}" src="
																@if(count($material->materials))
																	@if(count($material->materials->first()->products))
																		@if(count($material->materials->first()->products->first()->photos))
																		{{ asset("uploads/products/" . $material->materials->first()->products->first()->photos->first()->photo) }}
																		@elseif($material->materials->first()->products->first()->model->first()->photos)
																		{{ asset("uploads/models/" . $material->materials->first()->products->first()->model->first()->photos->first()->photo) }}
																		@else
																		{{ asset('store/images/demo_375x375.png') }}
																		@endif
																	@endif
																@endif">
															</a>
														</div>
														<div class="hover-overlay">
															<span class="col-name">
																<a href="online/products/?byMaterial[]={{ $material->id }}">
																	{{ $material->name }}
																</a>
															</span>
															<div class="collection-action">
																<a href="online/products/?byMaterial[]={{ $material->id }}">Виж</a>
															</div>
														</div>
													</div>
												</div>
												@endforeach

												<div class="home_collections_item">
													<div class="home_collections_item_inner">
														<div class="collection-details">
															<a href="{{ route('models') }}">
																@if(count($models) && count($models->first()->photos))
																	<img class="img-fill" alt="{{ $models->first()->name }}" src="{{ asset("uploads/models/" . $models->first()->photos->first()->photo) }}">
																@else
																	<img class="img-fill" alt="" src="{{ asset('store/images/demo_375x375.png') }}">
																@endif
															</a>
														</div>
														<div class="hover-overlay">
															<span class="col-name">
																<a href="{{ route('models') }}">По поръчка</a>
															</span>
															<div class="collection-action">
																<a href="{{ route('models') }}">Виж</a>
															</div>
														</div>
													</div>
												</div>

												<div class="home_collections_item">
													<div class="home_collections_item_inner">
														<div class="collection-details">
															<a href="{{ route('custom_order') }}">
																@if(count($models) && count($models->first()->photos))
																	<img class="img-fill" alt="{{ $models->first()->name }}" src="{{ asset("uploads/models/" . $models->first()->photos->first()->photo) }}">
																@else
																	<img class="img-fill" alt="" src="{{ asset('store/images/demo_375x375.png') }}">
																@endif
															</a>
														</div>
														<div class="hover-overlay">
															<span class="col-name">
																<a href="{{ route('custom_order') }}">По ваш модел</a>
															</span>
															<div class="collection-action">
																<a href="{{ route('custom_order') }}">Виж</a>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					@foreach($materials as $collect)
						<div class="home-feature">
							<div class="container">
								<div class="group_featured_products row">
									<div class="col-md-24">
										<div class="home_fp">
											<h6 class="general-title">Последни от {{ $collect->first()->parent->name }}</h6>
											<div class="home_fp_wrapper">
												<div class="home_fp2">
													@foreach($collect as $material)
														@foreach ( $material->productsOnline->take(10) as $key => $product )
															@if (Illuminate\Support\Str::lower($product->store_info->name) != 'склад')
															<li class="element no_full_width" data-alpha="{{ $product->name }}" data-price="{{ $product->price }}" data-id="{{$product->id}}">
																<ul class="row-container list-unstyled clearfix">

																	<li class="row-left">
																		<a href="{{ route('single_product', ['product' => $product->id])  }}" class="container_item">
																			<img  class="img-fill" class="img-zoom img-responsive image-fly" alt="{{ $product->name }}" src="
																			@if(count($product->photos))
																			{{ asset("uploads/products/" . $product->photos->first()['photo']) }}
																			@elseif(count($product->model->photos))
																			{{ asset("uploads/models/" . $product->model->photos->first()['photo']) }}
																			@else
																			{{ asset('store/images/demo_375x375.png') }}
																			@endif">
																		</a>
																		<div class="hbw">
																			<span class="hoverBorderWrapper"></span>
																		</div>
																	</li>

																	<li class="row-right parent-fly animMix">

																		<div class="product-content-left">
																			<a class="title-5" href="{{ route('single_product', ['product' => $product->id]) }}">
																				No: {{ implode(" ", str_split($product->id, 3)) }}
																			</a>
																			<br>
																			Модел: {{ $product->model->name }}
																			<br>
																			{{ $product->material->name }} - {{ $product->material->code }} - {{ $product->material->color }}
																			<br>
																			{{ $product->weight['weight'] }}гр.
																			<br>
																			@if(isset($product->weight['stone']))
																				@foreach($product->weight['stone'] as $productStone => $stone)
																					{{ $stone}}
																					@if(1 + $productStone < count($product->weight['stone'])) , @endif
																				@endforeach
																				<br>
																			@endif
																			Налично в: {{ $product->store_info->name }}
																			<span class="spr-badge" data-rating="0.0">
																			<span class="spr-starrating spr-badge-starrating">
																				{{$product->listProductAvgRatingStars($product)}}
																			</span>
																		</span>
																		</div>

																		<div class="product-content-right">
																			<div class="product-price">
																				<span class="price">
																					{{ number_format($product->price) }} лв.
																				</span>
																			</div>
																		</div>

																		<div class="hover-appear">
																			<a href="{{ route('single_product', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
																				<input name="quantity" value="1" type="hidden">
																				<i class="fa fa-lg fa-th-list"></i>
																				<span class="list-mode">Преглед</span>
																			</a>

																			<button class="product-ajax-qs hidden-xs hidden-sm quick_shop" data-target="#quick-shop-modal" data-toggle="modal"
																				 data-url="products/{{ $product->id }}/" title="Бърз Преглед">
																				<i class="fa fa-lg fa-eye"></i>
																				<span class="list-mode">Бърз преглед</span>
																			</button>

																			<button class="wish-list" title="Добави в желани"
																				 data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}">
																				<i class="fa fa-lg fa-heart"></i>
																				<span class="list-mode">Добави в желани</span>
																			</button>
																		</div>

																	</li>
																</ul>
															</li>
															@endif
														@endforeach
													@endforeach
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					@endforeach

					@if(count($articles))
					<div class="home-blog">
						<div class="container">
							<div class="home-promotion-blog row">
								<h6 class="general-title">Последни новини</h6>
							</div>

							@foreach($articles as $article)
							<div class="row home-blog__article">
								<div class="home-bottom_banner_wrapper col-md-12">
									@foreach( $article->thumbnail as $thumb)
										<div id="home-bottom_banner" class="home-bottom_banner">
											<a  href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' =>$article->slug])  }}">
												@if($thumb->language == 'bg')
													<div class="image-wrapper">
														<img src="{{ asset("uploads/blog/" . $thumb->photo) }}" alt="{{ $article->slug }}"/>
													</div>
												@endif
											</a>
										</div>
									@endforeach
								</div>
								<div class="home-blog-wrapper col-md-12">
									<div id="home_blog" class="home-blog">
										<div class="home-blog-item row">
											<div class="date col-md-4">
												<div class="date_inner">
													<p>
														<small>{{ $article->created_at->format('M') }}</small>
														<span>{{ $article->created_at->format('d') }}</span>
													</p>
												</div>
											</div>
											<div class="home-blog-content col-md-20">
												<h4>
													<a href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' => $article->slug])  }}">
														{{ str_limit($article->title, 40) }}
													</a>
												</h4>
												<ul class="list-inline">
													<li class="author">
														<i class="fa fa-user"></i>
														{{$article->author()->name}}
													</li>
													<li>/</li>
													<li class="comment">
														<a href="{{ route('single_translated_article', ['locale'=>app()->getLocale(), 'product' => $article->slug])  }}">
															<span>
																<i class="fa fa-pencil-square-o"></i>
																{{count($article->comments())}}
															</span>
															@if(count($article->comments()) == 1) Коментар @else Коментарa @endif </a>
													</li>
												</ul>
												<div class="intro">
													{{ str_limit($article->excerpt, 220) }}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							@endforeach
						</div>
					</div>
					@endif
				</div>
			</section>
		</div>
	</div>
</div>
@endsection