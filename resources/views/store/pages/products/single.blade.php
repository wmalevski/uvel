@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')

<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="view-product clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('single_product', $product) }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="col-main" class="product-page col-xs-24 col-sm-24 ">
							<div itemscope="" itemtype="http://schema.org/Product">
								<meta itemprop="url">
								<div id="product" class="content clearfix">
									<h1 id="page-title" class="text-center">
										<span itemprop="name">
											{{ implode(" ", str_split($product->id, 3)) }}
										</span>
									</h1>
									<div id="product-image" class="product-image row ">
										<div id="detail-left-column" class="hidden-xs left-coloum col-sm-6 col-sm-6 fadeInRight not-animated"
										 data-animate="fadeInRight">
											<div id="gallery_main" class="product-image-thumb thumbs full_width ">
												<ul class="slide-product-image">
													@foreach($product->photos as $photo)
														<li class="image">
															<a href="{{ asset("uploads/products/" . $photo->photo) }}" class="cloud-zoom-gallery active">
																<img alt="{{ $product->name }}" src="{{ asset("uploads/products/" . $photo->photo) }}">
															</a>
														</li>
													@endforeach
												</ul>
											</div>
										</div>
										<div class="image featured col-smd-12 col-sm-12 fadeInUp not-animated" data-animate="fadeInUp">
											<img alt="{{ $product->id }}" src="
											@if(count($product->photos))
											{{ asset("uploads/products/" . $product->photos->first()['photo']) }}
											@elseif(count($product->model->photos))
											{{ asset("uploads/models/" . $product->model->photos->first()['photo']) }}
											@else
											{{ asset('store/images/demo_375x375.png') }}
											@endif">
										</div>
										<div id="gallery_main_mobile" class="visible-xs product-image-thumb thumbs mobile_full_width ">
											<ul style="opacity: 0; display: block;" class="slide-product-image owl-carousel owl-theme">
												@foreach($product->photos as $photo)
												<li class="image">
													<a href="{{ asset("uploads/products/" . $photo->photo) }}" class="cloud-zoom-gallery active">
														<img src="{{ asset("uploads/products/" . $photo->photo) }}" alt="{{ $product->name }}">
													</a>
												</li>
												@endforeach
											</ul>
										</div>
										<div id="detail-right-column" class="right-coloum col-sm-6 fadeInLeft not-animated" data-animate="fadeInLeft">
										</div>
									</div>
									<div id="product-information" class="product-information row text-center ">
										<div id="product-header" class="clearfix">
											<div id="product-info-left">
												<div class="description">
													<ul>
														<li>
															<h5>Информация за продукта</h5>
															<ul class="sub">
																<li><span>No:</span> {{ implode(" ", str_split($product->id, 3)) }}</li>
																<li><span>Модел:</span> {{ $product->model->name }}</li>
																<li><span>{{ $product->material->name }} - {{ $product->material->code }} - {{ $product->material->color }}</span></li>
																<li><span>Тегло: {{ $product->weight['weight'] }}гр.</span></li>
																@if(isset($product->weight['stone']))
                                  <li>
																	@foreach($product->weight['stone'] as $productStone => $stone)
																		{{ $stone}}
																		@if(1 + $productStone < count($product->weight['stone'])) , @endif
																	@endforeach
                                  </li>
																@endif
																<li><span>Вид:</span> {{ $product->jewel->name }}</li>
																<li><span>Размер:</span> {{ $product->size }}</li>
																<li><span>Налично в:</span> {{ $product->store_info->name }}</li>
															</ul>
														</li>
													</ul>
                        </div>
                        @if($product->material->for_exchange == 'yes')
                          <div class="description">
                            <ul>
                              <li>
                                <h5>Обмяна</h5>
                                <ul class="sub">
                                  <li>{{ $weightWithoutStone }} гр. + {{ $product->workmanship }} лв.</li>
                                </ul>
                              </li>
                            </ul>
                          </div>
                        @endif
                      </div>
											<div id="product-info-right">
												<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" class="col-sm-24 group-variants">
													<meta itemprop="priceCurrency" content="USD">
													<link itemprop="availability" href="http://schema.org/InStock">
													<form action="./cart.html" method="post" class="variants" id="product-actions">
														<div id="product-actions-1293235843" class="options clearfix">
															<div id="purchase-1293235843">
																<div class="detail-price" itemprop="price">
																	<span class="price">
																		{{ number_format($product->price) }} лв.
																	</span>
																	*с ДДС
																</div>
															</div>
															<div class="others-bottom clearfix">

																<button id="add-to-cart" class="btn btn-1 add-to-cart"  type="submit" name="add"
																				data-url="{{ route('CartAddItem', ['item' => $product->barcode, 'quantity' => 1]) }}"
																 				data-parent=".product-information">
																 Добави в количка
																</button>

															</div>
														</div>
													</form>
													<div class="wls">
														@if (Auth::user() !== NULL)
														<a class="wish-list" data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}">
															<i class="fa fa-heart"></i> Добави в желани</a>
														<span>|</span>
														@endif

														<a href="mailto:uvelgold@gmail.com?subject=Продукт - {{ $product->id }}&body=No: {{ $product->id }} %0D%0A
														Модел: {{ $product->model->name }} %0D%0A
														{{ $product->material->name }} - {{ $product->material->code }} - {{ $product->material->color }} %0D%0A
														Тегло: {{ $product->weight['weight'] }}гр. %0D%0A
														Бижу: {{ $product->jewel->name }} %0D%0A
														Размер: {{ $product->size }} %0D%0A
														Налично в: {{ $product->store_info->name }}">
															<i class="fa fa-envelope"></i>
															Изпрати по email
														</a>
													</div>
												</div>
												<ul id="tabs_detail" class="tabs-panel-detail hidden-xs hidden-sm">
													<li class="first">
														<h5><a href="#pop-one" class="fancybox">Информация за обмяна</a></h5>
													</li>
													<li>
														<h5><a href="#pop-two" class="fancybox">Информация за доставка</a></h5>
													</li>
													<li>
														<h5><a href="#pop-three" class="fancybox">Таблица с размери</a></h5>
													</li>
												</ul>
												<div id="pop-one" style="display: none;">{!! App\CMS::get('exchange_info') !!}</div>
												<div id="pop-two" style="display: none;">{!! App\CMS::get('delivery_info') !!}</div>
												<div id="pop-three" style="display: none;">{!! App\CMS::get('sizes') !!}</div>
											</div>
										</div>
									</div>
									@if(Auth::check())
									<div id="shopify-product-reviews" data-id="{{$product->id}}">
										<div class="spr-container">
											@if(count($product->reviews) >= 1)
											<div class="spr-header">
												<h2 class="spr-header-title">Ревюта</h2>
												<div class="spr-summary" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
													<meta itemprop="itemreviewed">
													<meta itemprop="votes" content="{{count($product->reviews)}}">
													<span itemprop="rating" itemscope="" itemtype="http://data-vocabulary.org/Rating" class="spr-starrating spr-summary-starrating">
														<meta itemprop="average" content="{{$productAvgRating}}">
														<meta itemprop="best" content="5">
														<meta itemprop="worst" content="1">
														@for($i = 1; $i <= 5; $i++) @if(round($productAvgRating)>= $i)
															<i class="spr-icon spr-icon-star" style=""></i>
															@elseif(round($productAvgRating) < $i) <i class="spr-icon spr-icon-star-empty" style=""></i>
																@endif
																@endfor
													</span>
													<span class="spr-summary-caption">
														<span class="spr-summary-actions-togglereviews">
															({{$productAvgRating}}/5)
															Базирано на {{count($product->reviews)}}
															@if(count($product->reviews) == 1) ревю @else ревюта
															@endif
														</span>
													</span>
												</div>
											</div>
											@endif
											<div class="spr-content">
												<div class="spr-form" id="form_{{$product->id}}">
													<form method="post" data-form-captcha action="{{ route('product_review', ['product' => $product->id])  }}" id="new-review-form_{{$product->id}}"
													 class="new-review-form">
														{{ csrf_field() }}
														<input type="hidden" name="rating" value="5">
														<div
															id="review_form"
															data-size="invisible" data-captcha="review_form" data-callback="formSubmit">
														</div>
														<h3 class="spr-form-title">Напиши ревю</h3>
														<fieldset class="spr-form-review">
															<div class="spr-form-review-rating">
																<label class="spr-form-label">Рейтинг</label>
																<div class="spr-form-input spr-starrating">
																	<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="1">&nbsp;</a>
																	<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="2">&nbsp;</a>
																	<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="3">&nbsp;</a>
																	<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="4">&nbsp;</a>
																	<a href="#" class="spr-icon spr-icon-star spr-icon-star-empty" data-value="5">&nbsp;</a>
																</div>
															</div>

															<div class="spr-form-review-body">
																<label class="spr-form-label" for="review_body_{{$product->id}}">
																	Коментар
																	<span class="spr-form-review-body-charactersremaining">(1500)</span>
																</label>
																<div class="spr-form-input">
																	<textarea class="spr-form-input spr-form-input-textarea " id="review_body_{{$product->id}}"
																	 data-product-id="{{$product->id}}" name="content" rows="10" placeholder="Добавете вашият коментар"></textarea>
																</div>
															</div>

														</fieldset>
														<fieldset class="spr-form-actions">
															<button id="btnSubmitReview" type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" disabled>Добави рейтинг</button>
														</fieldset>
														<input type="hidden" name="product_id" value="{{$product->id}}">
														<input type="hidden" name="type" value="product">
													</form>
												</div>
												<div class="spr-reviews" id="reviews_{{$product->id}}">

													@foreach($product->reviews as $key => $review)
													<div class="spr-review" id="spr-review-{{$key}}">
														<div class="spr-review-header">
															<span class="spr-starratings spr-review-header-starratings">
																@for($i = 1; $i <= 5; $i++) @if($review->rating >= $i)
																	<i class="spr-icon spr-icon-star" style=""></i>
																	@elseif($review->rating < $i) <i class="spr-icon spr-icon-star-empty" style=""></i>
																		@endif
																		@endfor
															</span>
															<h3 class="spr-review-header-title">{{$review->user->name}}</h3>
															<span class="spr-review-header-byline">
																<strong>
																	{{ $review->created_at->format('d') }} {{ $review->created_at->format('M') }}, {{ $review->created_at->format('Y') }}
																</strong>
															</span>
														</div>

														<div class="spr-review-content">
															<p class="spr-review-content-body">
																{{$review->content}}
															</p>
														</div>

													</div>
													@endforeach

												</div>
											</div>
										</div>
									</div>
									@endif
								</div>
							</div>
							<!-- Related Products -->
							<section class="rel-container clearfix">
								<h6 class="general-title text-left">Подобни продукти, които може да ви харесат</h6>
								<div id="prod-related-wrapper">
									<div class="prod-related clearfix">
										@foreach($similarProducts as $product)
											@if (Illuminate\Support\Str::lower($product->store_info->name) != 'склад')
											<div class="element no_full_width not-animated" data-animate="bounceIn" data-delay="0">
												<ul class="row-container list-unstyled clearfix">
													<li class="row-left">
														<a href="{{ route('single_product', ['product' => $product->id]) }}" class="container_item">
															<img class="img-fill" alt="{{ $product->id }}" src="
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
															Налично в: {{ $product->store_info->name }}
															<span class="spr-badge" id="spr_badge_{{$product->id}}" data-rating="{{$product->getProductAvgRating($product)}}">
																<span class="spr-starrating spr-badge-starrating">{!! $product->listProductAvgRatingStars($product) !!}</span>
															</span>
														</div>
														<div class="product-content-right">
															<div class="product-price">
																<span class="price">{{ number_format($product->price) }} лв.</span>
															</div>
														</div>

														<div class="hover-appear">
															<a href="{{ route('single_product', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
																<input name="quantity" value="1" type="hidden">
																<i class="fa fa-lg fa-eye"></i>
																<span class="list-mode">Преглед</span>
															</a>

															<button class="wish-list" title="Добави в желани"
																			data-url="{{ route('wishlists_store', ['type' => 'product', 'item' => $product->id]) }}">
																<i class="fa fa-lg fa-heart"></i>
																<span class="list-mode">Добави в желани</span>
															</button>
														</div>

													</li>
												</ul>
											</div>
											@endif
										@endforeach
									</div>
								</div>
							</section>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('ol.breadcrumb li:nth-child(2) a').attr('href', $('ul.navbar-nav li.dropdown a').attr('href'));
	});
</script>
@endsection