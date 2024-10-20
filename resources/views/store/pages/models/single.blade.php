@extends('store.layouts.app', ['bodyClass' => 'templateProduct'])

@section('content')

<div class="modal fade edit--modal_holder" id="quick-shop-modal" role="dialog" aria-labelledby="quick-shop-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content"></div>
    </div>
</div>
<div id="content-wrapper-parent" class="store-page-models-single">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('single_model', $model) }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="col-main" class="product-page col-xs-24 col-sm-24 ">
							<div itemscope="" itemtype="http://schema.org/Product">
								<div id="product" class="content clearfix">
									<h1 id="page-title" class="text-center">
										<span itemprop="name">{{ $model->name }}</span>
									</h1>
									<div id="product-image" class="product-image row">
										<div id="detail-left-column" class="hidden-xs left-coloum col-sm-6 col-sm-6 fadeInRight not-animated" data-animate="fadeInRight">
											<div id="gallery_main" class="product-image-thumb thumbs full_width ">
												<ul class="slide-product-image">
													@foreach($model->photos as $image)
													<li class="image">
														<a href="{{ asset("uploads/models/" . $image->photo) }}" class="cloud-zoom-gallery active">
															<img src="{{ asset("uploads/models/" . $image->photo) }}" alt="{{ $model->name }}">
														</a>
													</li>
													@endforeach
												</ul>
											</div>
										</div>
										<div class="image featured col-smd-12 col-sm-12 fadeInUp not-animated" data-animate="fadeInUp">
											<img src="{{ asset("uploads/models/" . $model->photos->first()['photo']) }}" alt="{{ $model->name }}">
										</div>
										<div id="gallery_main_mobile" class="visible-xs product-image-thumb thumbs mobile_full_width ">
											<ul style="opacity: 0; display: block;" class="slide-product-image owl-carousel owl-theme">
												@foreach($model->photos as $image)
												<li class="image">
													<a href="{{ asset("uploads/models/" . $image->photo) }}" class="cloud-zoom-gallery active">
														<img src="{{ asset("uploads/models/" . $image->photo) }}" alt="{{ $model->name }}">
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
																<li><span>Модел:</span> {{ $model->name }}</li>
															@foreach($model->materials() as $material)
																<li><span>{{ $material->name }} {{ $material->code }} ({{ $material->color }})</span></li>
															@endforeach
																<li><span>Тегло: {{ $model->weight }}гр.</li>
																<li><span>Вид:</span> {{ $model->jewel->name }}</li>
																<li><span>Размер:</span> {{ $model->size }}</li>
															@if(isset($model->options->first()->material) && $model->options->first()->material->for_exchange == 'no')
                                                                <li><span>Обмяна:</span>{{ $model->weight }}<span style="text-transform:initial"> гр. + {{ $model->workmanship }} лв.</span></li>
                                                                @endif  
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
											</div>
											<div id="product-info-right">
												<div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer" class="col-sm-24 group-variants">
													<meta itemprop="priceCurrency" content="USD">
													<link itemprop="availability" href="http://schema.org/InStock">
													<form action="./cart.html" method="post" class="variants" id="product-actions">
														<div id="product-actions-1293235843" class="options clearfix">
															<style scoped>
																label[for="product-select-option-0"] { display: none; }
																  #product-select-option-0 { display: none; }
																  #product-select-option-0 + .custom-style-select-box { display: none !important; }
																</style>
															<div id="purchase-1293235843">
																<div class="detail-price" itemprop="price">
																	<span class="price">{{ number_format($model->price) }} лв.</span>
																	*с ДДС
																</div>
															</div>
															<div class="others-bottom clearfix">
																<button id="quick-shop-add" class="btn btn-1 add-to-cart" type="submit" data-url="{{ route('CartAddItem', ['item' => $model->barcode, 'quantity' => 1]) }}">Добави в количката</button>
															</div>
														</div>
													</form>
													<div class="wls">
														<a class="wish-list" href="#" data-url="{{ route('wishlists_store', ['type' => 'model', 'item' => $model->id]) }}"><i
															 class="fa fa-heart"></i> Добави в желани</a>
														<span>|</span>
														<a href="mailto:uvelgold@gmail.com?subject=По поръчка, Модел - {{ $model->id }}&body=Модел: {{ $model->id }} %0D%0A
														Тегло: {{ $model->weight }}гр. %0D%0A
														Бижу: {{ $model->jewel->name }} %0D%0A
														Размер: {{ $model->size }}">
															<i class="fa fa-envelope"></i> Изпрати по email</a>
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
									<div id="product-reviews">

										<div class="spr-container">
											<div class="spr-header">
												<h2 class="spr-header-title">Ревюта</h2>
												@if($model->getModelAvgRating($model) > 0)
												<div class="spr-summary" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
													<meta itemprop="itemreviewed">
													<meta itemprop="votes" content="{{count($model->reviews)}}">
													<span itemprop="rating" itemscope="" itemtype="http://data-vocabulary.org/Rating" class="spr-starrating spr-summary-starrating">
														<meta itemprop="average" content="{{$model->getModelAvgRating($model)}}">
														<meta itemprop="best" content="5">
														<meta itemprop="worst" content="1">
														{{$model->listModelAvgRatingStars($model)}}
													</span>

													<span class="spr-summary-caption">
														<span class="spr-summary-actions-togglereviews">
															({{$model->getModelAvgRating($model)}}/5)
															Базирано на {{count($model->reviews)}} @if(count($model->reviews) == 1) ревю @else ревюта
															@endif
														</span>
													</span>
												</div>
												@endif
											</div>
											<div class="spr-content">
												<div class="spr-form" id="form_1293236931">
													<form method="post" action="{{ route('product_review', ['product' => $model->id])  }}" id="new-review-form_{{$model->id}}"
													 class="new-review-form" data-form-captcha>
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
																<label class="spr-form-label" for="review_body_{{$model->id}}">
																	Коментар
																	<span class="spr-form-review-body-charactersremaining">(1500)</span></label>
																<div class="spr-form-input">
																	<textarea class="spr-form-input spr-form-input-textarea " id="review_body_{{$model->id}}"
																	 data-product-id="{{$model->id}}" name="content" rows="10" placeholder="Добавете вашият коментар"></textarea>
																</div>
															</div>
														</fieldset>
														<fieldset class="spr-form-actions">
															<button id="btnSubmitReview" type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" disabled>Добави рейтинг</button>
														</fieldset>
														<input type="hidden" name="model_id" value="{{$model->id}}">
														<input type="hidden" name="type" value="model">
													</form>
												</div>
												<div class="spr-reviews">
													@foreach($model->reviews as $key => $review)
													<div class="spr-review" id="spr-review-{{$key}}">
														<div class="spr-review-header">
															<span class="spr-starratings spr-review-header-starratings">
																@for($i = 1; $i <= 5; $i++) @if($review->rating >= $i)
																	<i class="spr-icon spr-icon-star" style=""></i>
																	@elseif($review->rating < $i) <i class="spr-icon spr-icon-star-empty" style=""></i>
																		@endif
																		@endfor
															</span>
															<h3 class="spr-review-header-title">
																{{ ($review->user ? $review->user->name : "Анонимен") }}
															</h3>
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
								</div>
							</div>
							<!-- Related Products -->
							<section class="rel-container clearfix">
								<h6 class="general-title text-left">Подобни продукти, които може да ви харесат</h6>
								<div id="prod-related-wrapper">
									<div class="prod-related clearfix">
										@foreach($similarModels as $model)
										<div class="element no_full_width not-animated" data-animate="bounceIn" data-delay="0">
											<ul class="row-container list-unstyled clearfix">
												<li class="row-left">
													<a href="{{ route('single_model', ['model' => $model->id]) }}" class="container_item">
														<img class="img-fill" alt="{{ $model->name }}" src="
														@if($model->photos) {{ asset("/uploads/models/".$model->photos->first()['photo']) }}
														@else {{ asset('store/images/demo_375x375.png') }}
														@endif">
													</a>
													<div class="hbw hidden-xs hidden-sm">
														<span class="hoverBorderWrapper"></span>
													</div>
												</li>
												<li class="row-right parent-fly animMix">
													<div class="product-content-left">
														<a class="title-5" href="{{ route('single_model', ['model' => $model->id])  }}">
															Модел: {{ $model->name }}
														</a>
														<br/>
														{{ $model->weight }}гр.
														<br/>
														<strong class="text-danger">По Поръчка за 10 дни</strong>
														<span class="spr-badge" data-rating="0.0">
															<span class="spr-starrating spr-badge-starrating">
																{{$model->listModelAvgRatingStars($model)}}
															</span>
															<span class="spr-badge-caption">No reviews</span>
														</span>
													</div>
													<div class="product-content-right">
														<div class="product-price">
															<span class="price">
																{{ number_format($model->price) }} лв.
															</span>
															*с ДДС
														</div>
													</div>

													<div class="hover-appear hidden-xs hidden-sm">
														<a href="{{ route('single_model', ['model' => $model->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
															<input name="quantity" value="1" type="hidden">
															<i class="fa fa-lg fa-eye"></i>
															<span class="list-mode">Преглед</span>
														</a>
													</div>
												</li>
											</ul>
										</div>
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