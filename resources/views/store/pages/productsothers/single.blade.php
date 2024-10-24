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
                        <div class="col-md-24">
                            {{ Breadcrumbs::render('single_product_other', $product) }}
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="col-main" class="product-page col-xs-24 col-sm-24 ">
                            <div>
                                <div id="product" class="content clearfix">
                                    <h1 id="page-title" class="text-center">
                                        <span itemprop="name">
                                            {{ $product->name }}
                                        </span>
                                    </h1>
                                    <div id="product-image" class="product-image row ">
                                        <div id="detail-left-column" class="hidden-xs left-coloum col-sm-6 col-sm-6 fadeInRight not-animated" data-animate="fadeInRight">
                                            <div id="gallery_main" class="product-image-thumb thumbs full_width ">
                                                <ul class="slide-product-image">
                                                    @if(App\Gallery::where('product_other_id', $product->id)->first()->get())
                                                        @foreach(App\Gallery::where('product_other_id', $product->id)->get() as $data)
                                                        <li class="image">
                                                            <a href="{{ asset("uploads/products_others/" . $data->photo) }}" class="cloud-zoom-gallery active">
                                                                <img src="{{ asset("uploads/products_others/" . $data->photo) }}" alt="{{ $product->name }}">
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="image featured col-smd-12 col-sm-12 fadeInUp not-animated" data-animate="fadeInUp">
                                            @if(App\Gallery::where('product_other_id', $product->id)->first()->get())
                                                <img src="{{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $product->id)->first()->photo) }}" alt="{{ $product->name }}">
                                            @endif
                                        </div>
                                        <div id="gallery_main_mobile" class="visible-xs product-image-thumb thumbs mobile_full_width ">
                                            <ul style="opacity: 0; display: block;" class="slide-product-image owl-carousel owl-theme">
                                                @if($product->photos)
                                                @foreach($product->photos as $image)
                                                <li class="image">
                                                    <a href="{{ asset("uploads/products/" . $image->photo) }}" class="cloud-zoom-gallery active">
                                                        <img src="{{ asset("uploads/products/" . $image->photo) }}" alt="{{ $product->name }}">
                                                    </a>
                                                </li>
                                                @endforeach
                                                @endif
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
                                                                <li>Модел: {{ $product->name }} </li>
                                                                <li>No: {{ $product->id }}</li>
                                                                <li>Налично в: {{ App\Store::where('id',$product->store_id)->first()->name }}</li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div id="product-info-right">
                                                <div itemprop="offers" itemtype="http://schema.org/Offer" class="col-sm-24 group-variants">
                                                    <meta itemprop="priceCurrency" content="USD">
                                                    <link itemprop="availability" href="http://schema.org/InStock">
                                                    <form action="./cart.html" method="post" class="variants" id="product-actions">
                                                        <div class="options clearfix">
                                                            <div class="quantity-wrapper clearfix">
                                                                <label class="wrapper-title">Количество</label>
                                                                <div class="wrapper">
                                                                    <input id="quantity" name="quantity" value="1" maxlength="5" size="5" class="item-quantity" type="text">
                                                                    <span class="qty-group">
                                                                        <span class="qty-wrapper">
                                                                            <span data-original-title="Увеличи" class="qty-up btooltip" data-toggle="tooltip" data-placement="top"
                                                                             title="" data-src="#quantity">
                                                                                <i class="fa fa-caret-right"></i>
                                                                            </span>
                                                                            <span data-original-title="Намали" class="qty-down btooltip" data-toggle="tooltip" data-placement="top"
                                                                             title="" data-src="#quantity">
                                                                                <i class="fa fa-caret-left"></i>
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="detail-price" itemprop="price">
                                                                    <span class="price">
                                                                        {{ number_format($product->price) }} лв.
                                                                    </span>
                                                                    *с ДДС
                                                                </div>
                                                            </div>
                                                            <div class="others-bottom clearfix">
                                                                <button id="add-to-cart" class="btn btn-1 add-to-cart productsothers" data-parent=".product-information"
                                                                 type="submit" data-url="{{ route('CartAddItem', ['item' => $product->barcode]) }}">
                                                                 Добави в количка
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                    <div class="wls">
                                                        <a class="wish-list" href="#" data-url="{{ route('wishlists_store', ['type' => 'product_other', 'item' => $product->id]) }}">
                                                            <i class="fa fa-heart"></i>
                                                            Добави в желани
                                                        </a>
                                                        <span>|</span>
                                                        <a href="mailto:uvelgold@gmail.com?subject={{ \App\ProductOtherType::where('id', $product->type_id)->first()->name }} - {{ $product->name }}&body=Модел: {{ $product->name }} %0D%0A
                                                        No: {{ $product->id }} %0D%0A
                                                        Налично в: {{ App\Store::where('id',$product->store_id)->first()->name }}">
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
                                    <div id="shopify-product-reviews">
                                        <div class="spr-container">
                                            <div class="spr-header">
                                                <h2 class="spr-header-title">Ревюта</h2>
                                                <div class="spr-summary" itemscope="" itemtype="http://data-vocabulary.org/Review-aggregate">
                                                    <meta itemprop="itemreviewed">
                                                    <meta itemprop="votes" content="{{count($product->reviews)}}">
                                                    <span itemprop="rating" itemscope="" itemtype="http://data-vocabulary.org/Rating" class="spr-starrating spr-summary-starrating">
                                                        <meta itemprop="average" content="{{$product->getProductOtherAvgRating($product)}}">
                                                        <meta itemprop="best" content="5">
                                                        <meta itemprop="worst" content="1">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if(round($product->getProductOtherAvgRating($product)) >= $i)
                                                                <i class="spr-icon spr-icon-star" style=""></i>
                                                            @elseif(round($product->getProductOtherAvgRating($product)) < $i)
                                                                <i class="spr-icon spr-icon-star-empty"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    @if(count($product->reviews) >= 1)
                                                    <span class="spr-summary-caption">
                                                        <span class="spr-summary-actions-togglereviews">
                                                            ({{$productAvgRating}}/5)
                                                            Базирано на {{count($product->reviews)}}
                                                            @if(count($product->reviews) == 1) ревю @else ревюта
                                                            @endif
                                                        </span>
                                                    </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="spr-content">
                                                <div class="spr-form" id="form_{{$product->id}}">
                                                    <form method="post" data-form-captcha action="{{ route('product_review', ['product' => $product->id]) }}" id="new-review-form_{{$product->id}}"
                                                     class="new-review-form">
                                                        {{ csrf_field() }}
                                                        <input type="hidden" name="rating" value="5">
                                                        <div
                                                            id="review_form"
                                                            data-size="invisible" data-captcha="review_form" data-callback="formSubmit">
                                                        </div>
                                                        <h3 class="spr-form-title">
                                                            Напиши ревю
                                                        </h3>
                                                        <fieldset class="spr-form-review">
                                                            <div class="spr-form-review-rating">
                                                                <label class="spr-form-label">Рейтинг</label>
                                                                <div class="spr-form-input spr-starrating ">
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
                                                                    <textarea class="spr-form-input spr-form-input-textarea" id="review_body_{{$product->id}}"
                                                                                        data-product-id="{{$product->id}}" name="content" rows="10" placeholder="Добавете вашият коментар"></textarea>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset class="spr-form-actions">
                                                            <button id="btnSubmitReview" type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" disabled>Добави рейтинг</button>
                                                        </fieldset>
                                                        <input type="hidden" name="product_others_id" value="{{$product->id}}">
                                                        <input type="hidden" name="type" value="product_other">
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
                                                            <h3 class="spr-review-header-title">
                                                                @if(!empty($review->user)){{$review->user->name}}@endif
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
                                        @foreach($similarProducts as $product)
                                        <div class="element no_full_width not-animated" data-animate="bounceIn" data-delay="0">
                                            <ul class="row-container list-unstyled clearfix">
                                                <li class="row-left">
                                                    <a href="{{ route('single_product', ['product' => $product->id]) }}" class="container_item">
                                                        <img class="img-fill" alt="{{ $product->name }}"
                                                                 src="@if(App\Gallery::where('product_other_id', $product->id)->first()) {{ asset("uploads/products_others/" . App\Gallery::where('product_other_id', $product->id)->first()->photo) }}
                                                                 @else {{ asset('store/images/demo_375x375.png') }} @endif">
                                                    </a>
                                                    <div class="hbw">
                                                        <span class="hoverBorderWrapper"></span>
                                                    </div>
                                                </li>
                                                <li class="row-right parent-fly animMix">
                                                    <div class="product-content-left">
                                                        <a class="title-5" href="{{ route('single_product_other', ['product' => $product->id]) }}">
                                                        Модел: {{ $product->name }}
                                                        </a>
                                                        <br />
                                                        No: {{ $product->id }}
                                                        <br />
                                                        Налично в: {{ App\Store::where('id',$product->store_id)->first()->name }}
                                                        <span class="spr-badge" id="spr_badge_{{$product->id}}" data-rating="{{$product->getProductOtherAvgRating($product)}}">
                                                            <span class="spr-starrating spr-badge-starrating">
                                                                {{$product->listProductOtherAvgRatingStars($product)}}
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div class="product-content-right">
                                                        <div class="product-price">
                                                            <span class="price">
                                                                {{ number_format($product->price) }} лв.
                                                            </span>
                                                            *с ДДС
                                                        </div>
                                                    </div>

                                                    <div class="hover-appear">
                                                        <a href="{{ route('single_product_other', ['product' => $product->id]) }}" class="effect-ajax-cart product-ajax-qs" title="Преглед">
                                                            <input name="quantity" value="1" type="hidden">
                                                            <i class="fa fa-lg fa-eye"></i>
                                                            <span class="list-mode">Преглед</span>
                                                        </a>

                                                        <button class="wish-list" title="Добави в Желани"
                                                             data-url="{{ route('wishlists_store', ['type' => 'product_other', 'item' => $product->id]) }}">
                                                            <i class="fa fa-lg fa-heart"></i>
                                                            <span class="list-mode">Добави в Желани</span>
                                                        </button>
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
@endsection
