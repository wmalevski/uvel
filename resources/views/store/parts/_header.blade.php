<header id="top" class="clearfix">
    <!--top-->
    <div class="container">
        <div class="top row">
        <div class="col-md-6 phone-shopping">
            <span>PHONE SHOPING (01) 123 456 UJ</span>
        </div>
        <div class="col-md-18">
            <ul class="text-right">
            <li class="customer-links hidden-xs">
                <ul id="accounts" class="list-inline">
                    {{-- <li class="my-account">
                        <a href="./account.html">My Account</a>
                    </li>   --}}
                    @auth
                        Здравейте, {{ Auth::user()->name }}
                    @endauth

                    @guest
                    <li class="login">    
                            <a href="{{ route('login') }}" id="customer_register_link">Вход</a>
                    </li>
                    <li>/</li>   
                    <li class="register">
                        <a href="{{ route('register') }}" id="customer_register_link">Регистрирай се</a>
                    </li> 
                    @endguest
                </ul>
            </li>      
            <li id="widget-social">
                <ul class="list-inline">            
                <li><a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Facebook"><i class="fa fa-facebook"></i></a></li>
                <li><a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Twitter"><i class="fa fa-twitter"></i></a></li>                        
                <li><a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Pinterest"><i class="fa fa-pinterest"></i></a></li>           
                </ul>
            </li>        
            </ul>
        </div>
        </div>
    </div>
    <!--End top-->
    <div class="line"></div>
    <!-- Navigation -->
    <div class="container">
        <div class="top-navigation">
            <ul class="list-inline">
                <li class="top-logo">
                    <a id="site-title" href="{{ route('store') }}" title="UVEL">          
                    <img class="img-responsive" src="{{ asset('store/images/logo.png') }}" alt="UVEL">          
                    </a>
                </li>
                <li class="navigation">			
                    <nav class="navbar">
                        <div class="clearfix">
                            <div class="navbar-header">
                                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="sr-only">Toggle main navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                            </div>
                            <div class="is-mobile visible-xs">
                                <ul class="list-inline">
                                    <li class="is-mobile-menu">
                                    <div class="btn-navbar" data-toggle="collapse" data-target=".navbar-collapse">
                                        <span class="icon-bar-group">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        </span>
                                    </div>
                                    </li>
                                    <li class="is-mobile-login">
                                    <div class="btn-group">
                                        <div class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="fa fa-user"></i>
                                        </div>
                                        @if (Auth::check())
                                        
                                        <ul class="customer dropdown-menu">
                                            <li class="logout">
                                                <a href="#">Профил</a>
                                            </li>
                                        </ul>
                                        @else
                                        <ul class="customer dropdown-menu">
                                            <li class="logout">
                                                <a href="#">Вход</a>
                                            </li>
                                            <li class="account last">
                                                <a href="{{ route('register') }}">Регистрация</a>
                                            </li>
                                        </ul>
                                        
                                        @endif
                                    </div>
                                    </li>
                                    <li class="is-mobile-wl">
                                    <a href="#"><i class="fa fa-heart"></i></a>
                                    </li>
                                    <li class="is-mobile-cart">
                                    <a href="#"><i class="fa fa-shopping-cart"></i></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="collapse navbar-collapse">
                                <ul class="nav navbar-nav hoverMenuWrapper">
                                    <li class="nav-item active">
                                        <a href="{{ route('store') }}">
                                            <span>Начало</span>
                                        </a>
                                    </li>
                                    <li class="nav-item dropdown">
										<a href="{{ route('products') }}" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
										<span>Бижута</span>
										<i class="fa fa-caret-down"></i>
										<i class="sub-dropdown1 visible-sm visible-md visible-lg"></i>
										<i class="sub-dropdown visible-sm visible-md visible-lg"></i>
										</a>
										<ul class="dropdown-menu" style="display: none;">
                                            @foreach($materialTypes as $material)
                                                <li class=""><a tabindex="-1" href="{{ route('products') }}?byMaterial={{ $material->id }}">{{ $material->name }}</a></li>
                                            @endforeach

                                            @foreach($productothertypes as $type)
                                                <li class=""><a tabindex="-1" href="{{ route('productsothers') }}?byType={{ $type->id }}">{{ $type->name }}</a></li>
                                            @endforeach
										</ul>
									</li>

                                    <li class="nav-item">
                                        <a href="{{ route('models') }}">
                                            <span>По поръчка</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('custom_order') }}">
                                            <span>По ваш модел</span>
                                        </a>
                                    </li>
                                    {{-- <li class="dropdown mega-menu">
                                        <a href="./collection.html" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
                                        <span>Collections</span>
                                        <i class="fa fa-caret-down"></i>
                                        <i class="sub-dropdown1 visible-sm visible-md visible-lg"></i>
                                        <i class="sub-dropdown visible-sm visible-md visible-lg"></i>
                                        </a>
                                        <div class="megamenu-container megamenu-container-1 dropdown-menu banner-bottom mega-col-4" style="">
                                            <ul class="sub-mega-menu">
                                                <li>
                                                <ul>
                                                    <li class="list-title">Collection Links</li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Dolorem Sed </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Proident Nulla </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Phasellus Leo <span class="megamenu-label hot-label">Hot</span>
                                                    </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Tristique Amet <span class="megamenu-label feature-label">Featured</span>
                                                    </a>
                                                    </li>
                                                </ul>
                                                </li>
                                                <li>
                                                <ul>
                                                    <li class="list-title">Collection Links</li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Dolorem Sed </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Proident Nulla <span class="megamenu-label new-label">New</span>
                                                    </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Phasellus Leo </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Tristique Amet </a>
                                                    </li>
                                                </ul>
                                                </li>
                                                <li>
                                                <ul>
                                                    <li class="list-title">Collection Links</li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Dolorem Sed </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Proident Nulla </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Phasellus Leo <span class="megamenu-label sale-label">Sale</span>
                                                    </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Tristique Amet </a>
                                                    </li>
                                                </ul>
                                                </li>
                                                <li>
                                                <ul>
                                                    <li class="list-title">Collection Links</li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Dolorem Sed <span class="megamenu-label new-label">New</span>
                                                    </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="#">Proident Nulla </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega">
                                                    <a href="./product.html">Phasellus Leo </a>
                                                    </li>
                                                    <li class="list-unstyled li-sub-mega last">
                                                    <a href="./product.html">Tristique Amet <span class="megamenu-label hot-label">Hot</span>
                                                    </a>
                                                    </li>
                                                </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </li> --}}
                                    {{-- <li class="dropdown mega-menu">
                                    <a href="./collection.html" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
                                    <span>Pages</span>
                                    <i class="fa fa-caret-down"></i>
                                    <i class="sub-dropdown1 visible-sm visible-md visible-lg"></i>
                                    <i class="sub-dropdown visible-sm visible-md visible-lg"></i>
                                    </a>
                                    <div class="megamenu-container megamenu-container-2 dropdown-menu banner-right mega-col-2" style="display: none;">
                                        <ul class="sub-mega-menu">
                                            <li>
                                            <ul>
                                                <li class="list-title">Page Layout</li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./collection.html">Collection full width </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./collection-left.html">Collection - left sidebar </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./collection-right.html">Collection - right sidebar </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./product.html">Product full width </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./product-left.html">Product - left sidebar </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./product-right.html">Product - right sidebar </a>
                                                </li>
                                            </ul>
                                            </li>
                                            <li>
                                            <ul>
                                                <li class="list-title">Page Content</li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./about-us.html">About </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./price-table.html">Price table </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./faqs.html">FAQs </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./testimonials.html">Testimonial </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega">
                                                <a href="./collection.html">New product introduction </a>
                                                </li>
                                                <li class="list-unstyled li-sub-mega last">
                                                <a href="./contact.html"> Contact </a>
                                                </li>
                                            </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    </li> --}}
                                    <li class="nav-item">
                                        <a href="{{ route('translated_articles', ['locale'=>app()->getLocale()]) }}">
                                            <span>Блог</span>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('contactus') }}">
                                            <span>Контакти</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </li>		  
                <li class="top-search hidden-xs">
                    <div class="header-search">
                        <a href="#">
                        <span data-toggle="dropdown">
                        <i class="fa fa-search"></i>
                        <i class="sub-dropdown1"></i>
                        <i class="sub-dropdown"></i>
                        </span>
                        </a>
                        <form id="header-search" class="search-form dropdown-menu" action="search.html" method="get">
                            <input type="hidden" name="type" value="product">
                            <input type="text" name="q" value="" accesskey="4" autocomplete="off" placeholder="Напиши нещо...">
                            <button type="submit" class="btn">Търси</button>
                        </form>
                    </div>
                </li>					
                <li class="umbrella hidden-xs">
                    <div id="umbrella" class="list-inline unmargin">
                        <div class="cart-link">
                            <a href="{{ route('cart') }}" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
                                <i class="sub-dropdown1"></i>
                                <i class="sub-dropdown"></i>
                                <div class="num-items-in-cart">
                                    <span class="icon">
                                        Количка
                                        <span class="number">1</span>
                                    </span>
                                </div>
                            </a>
                            {{-- <div id="cart-info" class="dropdown-menu" style="display: none;">
                                <div id="cart-content">
                                    <div class="items control-container">
                                        <div class="row items-wrapper">
                                            <a class="cart-close" title="Remove" href="javascript:void(0);"><i class="fa fa-times"></i></a>
                                            <div class="col-md-8 cart-left">
                                                <a class="cart-image" href="./product.html"><img src="{{ asset('store/images/demo_77x77.png') }}" alt="" title=""></a>
                                            </div>
                                            <div class="col-md-16 cart-right">
                                                <div class="cart-title">
                                                    <a href="./product.html">Product with left sidebar - black / small</a>
                                                </div>
                                                <div class="cart-price">
                                                    200.00 лв<span class="x"> x </span>1
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="subtotal">
                                        <span>Тотал:</span><span class="cart-total-right">200.00 лв</span>
                                    </div>
                                    <div class="action">
                                        <button class="btn" onclick="window.location='{{ route('cart') }}'">Чекаут</button><a class="btn btn-1" href="{{ route('cart') }}">Виж количката</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </li>		  		 
                <li class="mobile-search visible-xs">
                    <form id="mobile-search" class="search-form" action="search.html" method="get">
                        <input type="hidden" name="type" value="product">
                        <input type="text" class="" name="q" value="" accesskey="4" autocomplete="off" placeholder="Search something...">
                        <button type="submit" class="search-submit" title="search"><i class="fa fa-search"></i></button>
                    </form>
                </li>		  
            </ul>
        </div>
        <!--End Navigation-->
        <script>
            function addaffix(scr){
            if($(window).innerWidth() >= 1024){
                if(scr > $('#top').innerHeight()){
                if(!$('#top').hasClass('affix')){
                    $('#top').addClass('affix').addClass('animated');
                }
                }
                else{
                if($('#top').hasClass('affix')){
                    $('#top').prev().remove();
                    $('#top').removeClass('affix').removeClass('animated');
                }
                }
            }
            else $('#top').removeClass('affix');
            }
            $(window).scroll(function() {
            var scrollTop = $(this).scrollTop();
            addaffix(scrollTop);
            });
            $( window ).resize(function() {
            var scrollTop = $(this).scrollTop();
            addaffix(scrollTop);
            });
        </script>
    </div>
</header>