@extends('store.layouts.app')

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
                                        <h6 class="general-title">Popular Collections</h6>
                                        <div class="home_collections_wrapper">												
                                            <div id="home_collections">
                                                            <div class="home_collections_item">
                                                                <div class="home_collections_item_inner">
                                                                    <div class="collection-details">
                                                                        <a href="./collection.html" title="Browse our Bracelets">
                                                                            <img src="{{ asset('store/images/demo_270x270.png') }}" alt="Bracelets">
                                                                        </a>
                                                                    </div>
                                                                    <div class="hover-overlay">
                                                                        <span class="col-name"><a href="./collection.html">Bracelets</a></span>
                                                                        <div class="collection-action">
                                                                            <a href="./collection.html">See the Collection</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="home_collections_item">
                                                                <div class="home_collections_item_inner">
                                                                    <div class="collection-details">
                                                                        <a href="./collection.html" title="Browse our Earrings">
                                                                        <img src="{{ asset('store/images/demo_270x270.png') }}" alt="Earrings">
                                                                        </a>
                                                                    </div>
                                                                    <div class="hover-overlay">
                                                                        <span class="col-name"><a href="./collection.html">Earrings</a></span>
                                                                        <div class="collection-action">
                                                                            <a href="./collection.html">See the Collection</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="home_collections_item">
                                                                <div class="home_collections_item_inner">
                                                                    <div class="collection-details">
                                                                        <a href="./collection.html" title="Browse our Necklaces">
                                                                        <img src="{{ asset('store/images/demo_270x270.png') }}" alt="Necklaces">
                                                                        </a>
                                                                    </div>
                                                                    <div class="hover-overlay">
                                                                        <span class="col-name"><a href="./collection.html">Necklaces</a></span>
                                                                        <div class="collection-action">
                                                                            <a href="./collection.html">See the Collection</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="home_collections_item">
                                                                <div class="home_collections_item_inner">
                                                                    <div class="collection-details">
                                                                        <a href="./collection.html" title="Browse our Rings">
                                                                        <img src="{{ asset('store/images/demo_270x270.png') }}" alt="Rings">
                                                                        </a>
                                                                    </div>
                                                                    <div class="hover-overlay">
                                                                        <span class="col-name"><a href="./collection.html">Rings</a></span>
                                                                        <div class="collection-action">
                                                                            <a href="./collection.html">See the Collection</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="home_collections_item">
                                                                <div class="home_collections_item_inner">
                                                                    <div class="collection-details">
                                                                        <a href="./collection.html" title="Browse our Bracelets">
                                                                            <img src="{{ asset('store/images/demo_270x270.png') }}" alt="Bracelets">
                                                                        </a>
                                                                    </div>
                                                                    <div class="hover-overlay">
                                                                        <span class="col-name"><a href="./collection.html">Bracelets</a></span>
                                                                        <div class="collection-action">
                                                                            <a href="./collection.html">See the Collection</a>
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
                                        <h6 class="general-title">New Products</h6>
                                        <div class="home_products_wrapper">
                                            <div id="home_products">
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="0">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Curabitur cursus dignis">
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
                                                            <a class="title-5" href="./product.html">Curabitur cursus dignis</a>
                                                            <span class="spr-badge" id="spr_badge_12932382113" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$259.00</span>
                                                                <del class="price_compare"> $300.00</del>
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
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>                
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="1">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Curabitur cursus dignis">
                                                        </a>
                                                        <div class="hbw">
                                                            <span class="hoverBorderWrapper"></span>
                                                        </div>
                                                        </li>
                                                        <li class="row-right parent-fly animMix">
                                                        <div class="product-content-left">
                                                            <a class="title-5" href="./product.html">Curabitur cursus dignis</a>
                                                            <span class="spr-badge" id="spr_badge_12932396193" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price">
                                                                $200.00 </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="5141875779">Default Title</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="add-to-cart" type="submit" name="add"><i class="fa fa-shopping-cart"></i><span class="list-mode">Add to Cart</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="2">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Donec aliquam ante non">
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
                                                            <a class="title-5" href="./product.html">Donec aliquam ante non</a>
                                                            <span class="spr-badge" id="spr_badge_12932369312" data-rating="4.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            1 review </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$250.00</span>
                                                                <del class="price_compare"> $300.00</del>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option value="3947648771">black / small</option>
                                                                        <option selected="selected" value="3947648835">white / small</option>
                                                                        <option value="3947648899">black / medium</option>
                                                                        <option value="3947648963">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="3">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Donec condime fermentum">
                                                        </a>
                                                        <div class="hbw">
                                                            <span class="hoverBorderWrapper"></span>
                                                        </div>
                                                        </li>
                                                        <li class="row-right parent-fly animMix">
                                                        <div class="product-content-left">
                                                            <a class="title-5" href="./product.html">Donec condime fermentum</a>
                                                            <span class="spr-badge" id="spr_badge_12932358434" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price">
                                                                $200.00 </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="3947646083">black / small</option>
                                                                        <option value="3947646147">red / small</option>
                                                                        <option value="3947646211">white / small</option>
                                                                        <option value="3947646275">blue / small</option>
                                                                        <option value="3947646339">black / medium</option>
                                                                        <option value="3947646403">red / medium</option>
                                                                        <option value="3947646467">blue / medium</option>
                                                                        <option value="3947646531">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>               
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="4">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Maximus quam posuere">
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
                                                            <a class="title-5" href="./product.html">Maximus quam posuere</a>
                                                            <span class="spr-badge" id="spr_badge_1293227907" data-rating="3.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            1 review </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$200.00</span>
                                                                <del class="price_compare"> $300.00</del>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="3947629763">black / small</option>
                                                                        <option value="3947629827">white / small</option>
                                                                        <option value="3947629891">black / medium</option>
                                                                        <option value="3947629955">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>                
                                                <div class="element no_full_width col-md-8 col-sm-8 not-animated" data-animate="fadeInUp" data-delay="5">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_375x375.png') }}" class="img-responsive" alt="Product full width">
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
                                                            <a class="title-5" href="./product.html">Product full width</a>
                                                            <span class="spr-badge" id="spr_badge_1293240771" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$200.00</span>
                                                                <del class="price_compare"> $300.00</del>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="3947656579">black / small</option>
                                                                        <option value="3947656643">white / small</option>
                                                                        <option value="3947656707">black / medium</option>
                                                                        <option value="3947656771">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home-banner-wrapper">
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
                    </div>
                    <div class="home-blog">
                        <div class="container">
                            <div class="home-promotion-blog row">
                                <h6 class="general-title">Latest News</h6>
                                <div class="home-bottom_banner_wrapper col-md-12">
                                    <div id="home-bottom_banner" class="home-bottom_banner">
                                        <a href="./collection.html"><img src="{{ asset('store/images/demo_570x415.png') }}" alt=""></a>
                                    </div>
                                </div>
                                <div class="home-blog-wrapper col-md-12">
                                    <div id="home_blog" class="home-blog">
                                        <div class="home-blog-item row">
                                            <div class="date col-md-4">
                                                <div class="date_inner">
                                                    <p>
                                                        <small>July</small><span>08</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="home-blog-content col-md-20">
                                                <h4><a href="./article-left.html">sample blog post with left slidebar</a></h4>
                                                <ul class="list-inline">
                                                    <li class="author"><i class="fa fa-user"></i> Jin Alkaid</li>
                                                    <li>/</li>
                                                    <li class="comment">
                                                    <a href="./article-left">
                                                    <span><i class="fa fa-pencil-square-o"></i> 0</span> Comments </a>
                                                    </li>
                                                </ul>
                                                <div class="intro">
                                                    Shoe street style leather tote oversized sweatshirt A.P.C. Prada Saffiano crop slipper denim shorts spearmint....
                                                </div>
                                            </div>
                                        </div>
                                        <div class="home-blog-item row">
                                            <div class="date col-md-4">
                                                <div class="date_inner">
                                                    <p>
                                                        <small>June</small><span>30</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="home-blog-content col-md-20">
                                                <h4><a href="./article.html">vel illum qui dolorem eum fugiat</a></h4>
                                                <ul class="list-inline">
                                                    <li class="author"><i class="fa fa-user"></i> Jin Alkaid</li>
                                                    <li>/</li>
                                                    <li class="comment">
                                                    <a href="./article.html">
                                                    <span><i class="fa fa-pencil-square-o"></i> 1</span> Comment </a>
                                                    </li>
                                                </ul>
                                                <div class="intro">
                                                    Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem...
                                                </div>
                                            </div>
                                        </div>
                                        <div class="home-blog-item row">
                                            <div class="date col-md-4">
                                                <div class="date_inner">
                                                    <p>
                                                        <small>June</small><span>30</span>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="home-blog-content col-md-20">
                                                <h4><a href="./article-right.html">sample blog post full width</a></h4>
                                                <ul class="list-inline">
                                                    <li class="author"><i class="fa fa-user"></i> Jin Alkaid</li>
                                                    <li>/</li>
                                                    <li class="comment">
                                                    <a href="./article-right.html">
                                                    <span><i class="fa fa-pencil-square-o"></i> 0</span> Comments </a>
                                                    </li>
                                                </ul>
                                                <div class="intro">
                                                    Shoe street style leather tote oversized sweatshirt A.P.C. Prada Saffiano crop slipper denim shorts spearmint....
                                                </div>
                                            </div>
                                        </div>
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
                                        <h6 class="general-title">Featured Products</h6>
                                        <div class="home_fp_wrapper">
                                            <div id="home_fp">   																						
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="0">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_277x277.png') }}" class="img-responsive" alt="Curabitur cursus dignis">
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
                                                            <a class="title-5" href="./product.html">Curabitur cursus dignis</a>
                                                            <span class="spr-badge" id="spr_badge_1293238211" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$259.00</span>
                                                                <del class="price_compare"> $300.00</del>
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
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>														  			  			
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="200">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_277x277.png') }}" class="img-responsive" alt="Curabitur cursus dignis">
                                                        </a>
                                                        <div class="hbw">
                                                            <span class="hoverBorderWrapper"></span>
                                                        </div>
                                                        </li>
                                                        <li class="row-right parent-fly animMix">
                                                        <div class="product-content-left">
                                                            <a class="title-5" href="./product.html">Curabitur cursus dignis</a>
                                                            <span class="spr-badge" id="spr_badge_1293239619" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price">
                                                                $200.00 </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="5141875779">Default Title</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="add-to-cart" type="submit" name="add"><i class="fa fa-shopping-cart"></i><span class="list-mode">Add to Cart</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>			  
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="400">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_277x277.png') }}" class="img-responsive" alt="Donec aliquam ante non">
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
                                                            <a class="title-5" href="./product.html">Donec aliquam ante non</a>
                                                            <span class="spr-badge" id="spr_badge_1293236931" data-rating="4.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            1 review </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$250.00</span>
                                                                <del class="price_compare"> $300.00</del>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option value="3947648771">black / small</option>
                                                                        <option selected="selected" value="3947648835">white / small</option>
                                                                        <option value="3947648899">black / medium</option>
                                                                        <option value="3947648963">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>													  
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="600">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_277x277.png') }}" class="img-responsive" alt="Donec condime fermentum">
                                                        </a>
                                                        <div class="hbw">
                                                            <span class="hoverBorderWrapper"></span>
                                                        </div>
                                                        </li>
                                                        <li class="row-right parent-fly animMix">
                                                        <div class="product-content-left">
                                                            <a class="title-5" href="./product.html">Donec condime fermentum</a>
                                                            <span class="spr-badge" id="spr_badge_1293235843" data-rating="0.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            No reviews </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price">
                                                                $200.00 </span>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="3947646083">black / small</option>
                                                                        <option value="3947646147">red / small</option>
                                                                        <option value="3947646211">white / small</option>
                                                                        <option value="3947646275">blue / small</option>
                                                                        <option value="3947646339">black / medium</option>
                                                                        <option value="3947646403">red / medium</option>
                                                                        <option value="3947646467">blue / medium</option>
                                                                        <option value="3947646531">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>			  
                                                <div class="element no_full_width not-animated" data-animate="fadeInUp" data-delay="800">
                                                    <ul class="row-container list-unstyled clearfix">
                                                        <li class="row-left">
                                                        <a href="./product.html" class="container_item">
                                                        <img src="{{ asset('store/images/demo_277x277.png') }}" class="img-responsive" alt="Maximus quam posuere">
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
                                                            <a class="title-5" href="./product.html">Maximus quam posuere</a>
                                                            <span class="spr-badge" id="spr_badge_12932279073" data-rating="3.0">
                                                            <span class="spr-starrating spr-badge-starrating"><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i><i class="spr-icon spr-icon-star-empty" style=""></i></span>
                                                            <span class="spr-badge-caption">
                                                            1 review </span>
                                                            </span>
                                                        </div>
                                                        <div class="product-content-right">
                                                            <div class="product-price">
                                                                <span class="price_sale">$200.00</span>
                                                                <del class="price_compare"> $300.00</del>
                                                            </div>
                                                        </div>
                                                        <div class="list-mode-description">
                                                                Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis amet voluptas assumenda est, omnis dolor repellendus quis nostrum. Temporibus autem quibusdam et aut officiis debitis aut rerum dolorem necessitatibus saepe eveniet ut et neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed...
                                                        </div>
                                                        <div class="hover-appear">
                                                            <form action="./product.html" method="post">
                                                                <div class="hide clearfix">
                                                                    <select name="id">
                                                                        <option selected="selected" value="3947629763">black / small</option>
                                                                        <option value="3947629827">white / small</option>
                                                                        <option value="3947629891">black / medium</option>
                                                                        <option value="3947629955">white / medium</option>
                                                                    </select>
                                                                </div>
                                                                <div class="effect-ajax-cart">
                                                                    <input type="hidden" name="quantity" value="1">
                                                                    <button class="select-option" type="button" onclick="window.location.href='product.html'"><i class="fa fa-th-list" title="Select Options"></i><span class="list-mode">Select Option</span></button>
                                                                </div>
                                                            </form>
                                                            <div class="product-ajax-qs hidden-xs hidden-sm">
                                                                <div data-href="./ajax/_product-qs.html" data-target="#quick-shop-modal" class="quick_shop" data-toggle="modal">
                                                                    <i class="fa fa-eye" title="Quick view"></i><span class="list-mode">Quick View</span>																		
                                                                </div>
                                                            </div>
                                                            <a class="wish-list" href="./account.html" title="wish list"><i class="fa fa-heart"></i><span class="list-mode">Add to Wishlist</span></a>
                                                        </div>
                                                        </li>
                                                    </ul>
                                                </div>  			                          
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="home-partners">
                        <div class="container">
                            <div class="partners-logo row">
                                <div class="col-md-24">
                                    <div id="partners-container" class="clearfix">
                                        <h6 class="general-title">Popular Brands</h6>
                                        <div id="partners">
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="150">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="300">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="450">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="600">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="750">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="900">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                                        <div class="logo text-center not-animated" data-animate="bounceIn" data-delay="1050">
                                                            <a class="animated" href="./collection.html">
                                                            <img class="pulse" src="{{ asset('store/images/demo_154x43.png') }}" alt="">
                                                            </a>
                                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>  				            
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection