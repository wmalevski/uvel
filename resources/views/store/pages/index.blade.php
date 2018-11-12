@extends('store.layouts.app', ['bodyClass' => 'templateIndex'])

@section('content')
<div id="content-wrapper-parent">
    <div id="content-wrapper">  
        <!-- Main Slideshow -->
        <div class="home-slider-wrapper clearfix">
            <div class="camera_wrap" id="home-slider">
                <div data-src="{{ asset('store/images/demo_1920x900.png') }}">
                    <div class="camera_caption camera_title_1 fadeIn">
                        <a href="./collection.html" style="color:#010101;">Live the moment</a>
                    </div>
                    <div class="camera_caption camera_caption_1 fadeIn" style="color: rgb(1, 1, 1);">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    </div>
                    <div class="camera_caption camera_image-caption_1 moveFromLeft">
                        <img src="{{ asset('store/images/demo_734x90.png') }}" alt="image_caption">
                    </div>
                    <div class="camera_cta_1">
                        <a href="./collection.html" class="btn">See Collection</a>
                    </div>
                </div>
                <div data-src="{{ asset('store/images/demo_1920x900.png') }}">
                    <div class="camera_caption camera_title_2 moveFromLeft">
                        <a href="./collection.html" style="color:#666666;">Love’s embrace</a>
                    </div>
                    <div class="camera_caption camera_image-caption_2 moveFromLeft" style="visibility: hidden;">
                        <img src="{{ asset('store/images/demo_770x185.png') }}" alt="image_caption">
                    </div>
                    <div class="camera_cta_1">
                        <a href="./collection.html" class="btn">See Collection</a>
                    </div>
                </div>
                <div data-src="{{ asset('store/images/demo_1920x900.png') }}">
                    <div class="camera_caption camera_image-caption_3 moveFromLeft">
                        <img src="{{ asset('store/images/demo_462x162.png') }}" alt="image_caption">
                    </div>
                    <div class="camera_cta_1">
                        <a href="./collection.html" class="btn">See Collection</a>
                    </div>
                </div>
            </div>
        </div> 
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
                                                                <a href="online/products/?byMaterial={{ $material->id }}" title="Browse our Bracelets">
                                                                        <img src="
                                                                        @if(count($material->materials->first()->products)) 
                                                                        {{ asset("uploads/products/" . $material->materials->first()->products->first()->images->first()->photo) }} @else {{ asset('store/images/demo_375x375.png') }} @endif
                                                                        " alt="Bracelets">
                                                                </a>
                                                            </div>
                                                            <div class="hover-overlay">
                                                                <span class="col-name"><a href="online/products/?byMaterial={{ $material->id }}">{{ $material->name }}</a></span>
                                                                <div class="collection-action">
                                                                    <a href="online/products/?byMaterial={{ $material->id }}">Виж</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach

                                                
                                                <div class="home_collections_item">
                                                    <div class="home_collections_item_inner">
                                                        <div class="collection-details">
                                                            <a href="{{ route('models') }}" title="Browse our Bracelets">
                                                                {{-- <img src="
                                                                @if($type->productOther->first()->products->first()->images) 
                                                                {{ asset("uploads/products/" . $material->materials->first()->products->first()->images->first()->photo) }} @else {{ asset('store/images/demo_375x375.png') }} @endif
                                                                " alt="Bracelets"> --}}
                                                                <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="По поръчка">
                                                            </a>
                                                        </div>
                                                        <div class="hover-overlay">
                                                            <span class="col-name"><a href="{{ route('models') }}">По поръчка</a></span>
                                                            <div class="collection-action">
                                                                <a href="{{ route('models') }}">Виж</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="home_collections_item">
                                                        <div class="home_collections_item_inner">
                                                            <div class="collection-details">
                                                                <a href="{{ route('custom_order') }}" title="Browse our Bracelets">
                                                                    {{-- <img src="
                                                                    @if($type->productOther->first()->products->first()->images) 
                                                                    {{ asset("uploads/products/" . $material->materials->first()->products->first()->images->first()->photo) }} @else {{ asset('store/images/demo_375x375.png') }} @endif
                                                                    " alt="Bracelets"> --}}
                                                                    <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="По поръчка">
                                                                </a>
                                                            </div>
                                                            <div class="hover-overlay">
                                                                <span class="col-name"><a href="{{ route('custom_order') }}">По ваш модел</a></span>
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
                                    <script>
                                        $(document).ready(function() {
                                        $('.collection-details').hover(
                                            function() {
                                            $(this).parent().addClass("collection-hovered");
                                            },
                                            function() {
                                            $(this).parent().removeClass("collection-hovered");
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                    </div>
                    <div class="home-newproduct">
                        <div class="container">
                            <div class="group_home_products row">
                                <div class="col-md-24">
                                    <div class="home_products">
                                        <h6 class="general-title">Нови продукти</h6>
                                        <div class="home_products_wrapper">
                                            <div id="home_products">
                                                @foreach ( $products->take(3) as $key => $product ) 
                                                    <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="{{ $key }}">
                                                        <ul class="row-container list-unstyled clearfix">
                                                            <li class="row-left">
                                                            <a href="{{ route('single_product', ['product' => $product['id']])  }}" class="container_item">
                                                            <img src="@if($product->photos) {{ asset("uploads/products/" . $product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="{{ $product['name'] }}">
                                                            </a>
                                                            <div class="hbw">
                                                                <span class="hoverBorderWrapper"></span>
                                                            </div>
                                                            </li>
                                                            <li class="row-right parent-fly animMix">
                                                            <div class="product-content-left">
                                                                <a class="title-5" href="./product.html">{{ $product['name'] }}</a>
                                                                <span class="spr-badge" id="spr_badge_12932396193" data-rating="{{$product->getSimilarProductAvgRating($product)}}">
                                                                <span class="spr-starrating spr-badge-starrating">
                                                                    {{$product->listSimilarProductAvgRatingStars($product)}}
                                                                </span>
                                                                <span class="spr-badge-caption">
                                                                No reviews </span>
                                                                </span>
                                                            </div>
                                                            <div class="product-content-right">
                                                                <div class="product-price">
                                                                    <span class="price">{{ $product['price'] }} лв</span>
                                                                </div>
                                                            </div>
                                                            <div class="list-mode-description">
                                                                    Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                            </div>
                                                            <div class="hover-appear">
                                                                <form action="./product.html" method="post">
                                                                    <div class="hide clearfix">
                                                                        <select name="id">
                                                                            <option selected="selected" value="5141875779">{{ $product['name'] }}</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="effect-ajax-cart">
                                                                        <input type="hidden" name="quantity" value="1">
                                                                        <button class="add-to-cart" type="submit" name="add"><i class="fa fa-shopping-cart"></i><span class="list-mode">Add to Cart</span></button>
                                                                    </div>
                                                                </form>
                                                                <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                    <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-barcode="{{ $product->barcode }}" data-toggle="modal">
                                                                        <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                    </div>
                                                                </div>
                                                                <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                            </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                @endforeach               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="home-banner-wrapper">
                        <div class="container">
                            <div id="home-banner" class="text-center clearfix">
                                <img class="pulse img-banner-caption" src="./assets/images/demo_230x235.png" alt="">
                                <div class="home-banner-caption">
                                    <p>
                                        Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.<br>
                                            Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                    </p>
                                </div>
                                <div class="home-banner-action">
                                    <a href="./collection.html">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="home-blog">
                        <div class="container">
                            <div class="home-promotion-blog row">
                                <h6 class="general-title">Последни новини</h6>
                                @if(count($articles))
                                <div class="home-bottom_banner_wrapper col-md-12">
                                    <div id="home-bottom_banner" class="home-bottom_banner">
                                     <a href="{{ route('single_article', ['product' => $articles->first()->slug.'-'.$articles->first()->id])  }}"><img src="{{ asset("uploads/blog/" . $articles->first()->thumbnail) }}" alt=""></a>
                                    </div>
                                </div>
                                @endif
                                <div class="home-blog-wrapper col-md-12">
                                    <div id="home_blog" class="home-blog">
                                        @foreach($articles as $article)
                                        <div class="home-blog-item row">
                                                <div class="date col-md-4">
                                                    <div class="date_inner">
                                                        <p>
                                                            <small>{{ $article->created_at->format('M') }}</small><span>{{ $article->created_at->format('d') }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="home-blog-content col-md-20">
                                                    <h4><a href="{{ route('single_article', ['product' => $article->slug])  }}">{{ $article->title }}</a></h4>
                                                    <ul class="list-inline">
                                                        <li class="author"><i class="fa fa-user"></i> {{$article->author()->name}}</li>
                                                        <li>/</li>
                                                        <li class="comment">
                                                        <a href="{{ route('single_article', ['product' => $article->slug])  }}">
                                                        <span><i class="fa fa-pencil-square-o"></i> {{count($article->comments())}}</span> Comments </a>
                                                        </li>
                                                    </ul>
                                                    <div class="intro">
                                                        {{ $article->excerpt }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home-feature">
                        <div class="container">
                            <div class="group_featured_products row">
                                <div class="col-md-24">
                                    <div class="home_fp">
                                        <h6 class="general-title">Още продукти</h6>
                                        <div class="home_fp_wrapper">
                                            <div id="home_fp">  
                                                @foreach ( $products->take(10) as $key => $product ) 					
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="0">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="product/{{ $product['id'] }}" class="container_item">
                                                        <img src="@if($product->photos) {{ asset("uploads/products/" . $product->photos->first()['photo']) }} @else {{ asset('store/images/demo_375x375.png') }} @endif" class="img-responsive" alt="Curabitur cursus dignis">
                                                        <span class="sale_banner">
                                                        <span class="sale_text">Sale</span>
                                                        </span>
                                                        </a>
                                                        <div class="hbw">
                                                            <span class="hoverBorderWrapper"></span>
                                                        </div>
                                                        </li>
                                                        <li class="row-right parent-fly animMix">
                                                            <div class="product-content-left">
                                                                <a class="title-5" href="./product.html">{{ $product->name }}</a>
                                                                <span class="spr-badge" id="spr_badge_1293238211" data-rating="{{$product->getSimilarProductAvgRating($product)}}">
                                                                <span class="spr-starrating spr-badge-starrating">
                                                                    {{$product->listSimilarProductAvgRatingStars($product)}}
                                                                </span>
                                                                <span class="spr-badge-caption">
                                                                No reviews </span>
                                                                </span>
                                                            </div>
                                                            <div class="product-content-right">
                                                                <div class="product-price">
                                                                    <span class="price">{{ $product->price }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="list-mode-description">
                                                                    Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                            </div>
                                                            <div class="hover-appear">
                                                                <form action="./product.html" method="post">
                                                                    <div class="effect-ajax-cart">
                                                                        <input type="hidden" name="quantity" value="1">
                                                                        <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                    </div>
                                                                </form>
                                                                <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                    <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-barcode="{{ $product->barcode }}" data-toggle="modal">
                                                                        <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                    </div>
                                                                </div>
                                                                <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                @endforeach														  			  			
                                            </div>
                                        </div>
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