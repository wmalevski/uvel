<header id="top" class="clearfix">
	<!--top-->
	<div class="container top">
		<div class="top row">
			<div class="col-md-6 phone-shopping">
				<span>За поръчки 08786248579</span>
			</div>
			<div class="col-md-18">
				<ul class="text-right">
					<li class="customer-links hidden-xs">
						<ul id="accounts" class="list-inline">
							{{-- <li class="my-account">
								<a href="./account.html">My Account</a>
							</li> --}}
							@auth
							Здравейте, {{ Auth::user()->name }}
							<li class="login">
								<a href="{{ route('logout') }}" id="customer_register_link">Изход</a>
							</li>
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
							<li>
								<a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title=""
									data-original-title="Facebook">
								 	<i class="fa fa-facebook"></i>
								</a>
							</li>
							<li>
								<a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title=""
									data-original-title="Twitter">
									<i class="fa fa-twitter"></i>
								</a>
							</li>
							<li>
								<a target="_blank" href="#" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title=""
								 	data-original-title="Pinterest">
								 	<i class="fa fa-pinterest"></i>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!--End top-->
	<div class="line"></div>
	<!-- Navigation -->
	<div class="container bottom">
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
													<a href="{{ route('user_account') }}">Профил</a>
												</li>
												<li class="logout">
													<a href="{{ route('logout') }}">Изход</a>
												</li>

											</ul>
											@else
											<ul class="customer dropdown-menu">
												<li class="logout">
													<a href="{{ route('login') }}">Вход</a>
												</li>
												<li class="account last">
													<a href="{{ route('register') }}">Регистрация</a>
												</li>
											</ul>

											@endif
										</div>
									</li>
									@if (Auth::check())
									<li class="is-mobile-wl">
										<a href="{{ route('wishlist') }}"><i class="fa fa-heart"></i></a>
									</li>
									@endif
									<li class="is-mobile-cart">
										<a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i></a>
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
											<span>Налични Бижута</span>
											<i class="fa fa-caret-down"></i>
											<i class="sub-dropdown1 visible-sm visible-md visible-lg"></i>
											<i class="sub-dropdown visible-sm visible-md visible-lg"></i>
										</a>
										<ul class="dropdown-menu" style="display: none;">
											@foreach($materialTypes as $material)
											<li class=""><a tabindex="-1" href="{{ route('products') }}?byMaterial[]={{ $material->id }}">{{
													$material->name }}</a></li>
											@endforeach

											@foreach($productothertypes as $type)
											<li class=""><a tabindex="-1" href="{{ route('productsothers') }}?byType[]={{ $type->id }}">{{ $type->name
													}}</a></li>
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
					{{--
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
				</li> --}}
				<li class="umbrella hidden-xs">
					<div id="umbrella" class="list-inline unmargin">
						<div class="cart-link">
							<a href="{{ route('cart') }}" class="dropdown-toggle dropdown-link" data-toggle="dropdown">
								<i class="sub-dropdown1"></i>
								<i class="sub-dropdown"></i>
								<div class="num-items-in-cart">
									<span class="icon">
										Количка
										<span class="number">
											@if(Auth::check())
											{{ Cart::session(Auth::user()->getId())->getTotalQuantity() }}
											@else
											0
											@endif
										</span>
									</span>
								</div>
							</a>
							{{-- <div id="cart-info" class="dropdown-menu" style="display: none;">
								<div id="cart-content">
									<div class="items control-container">
										<div class="row items-wrapper">
											<a class="cart-close" title="Remove" href="javascript:void(0);"><i class="fa fa-times"></i></a>
											<div class="col-md-8 cart-left">
												<a class="cart-image" href="./product.html"><img src="{{ asset('store/images/demo_77x77.png') }}" alt=""
													 title=""></a>
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
										<button class="btn" onclick="window.location='{{ route('cart') }}'">Чекаут</button><a class="btn btn-1" href="{{ route('cart') }}">Виж
											количката</a>
									</div>
								</div>
							</div> --}}
						</div>
					</div>
				</li>
				{{-- <li class="mobile-search visible-xs">
					<form id="mobile-search" class="search-form" action="search.html" method="get">
						<input type="hidden" name="type" value="product">
						<input type="text" class="" name="q" value="" accesskey="4" autocomplete="off" placeholder="Search something...">
						<button type="submit" class="search-submit" title="search"><i class="fa fa-search"></i></button>
					</form>
				</li> --}}
			</ul>
		</div>
		<!--End Navigation-->
		<script>
			function addaffix(scr) {
				if ($(window).innerWidth() >= 1024) {
					if (scr > $('header').innerHeight()) {
						if (!$('header').hasClass('affix')) {
							$('header').addClass('affix').addClass('animated');
						}
					} else {
						if ($('header').hasClass('affix')) {
							$('header').prev().remove();
							$('header').removeClass('affix').removeClass('animated');
						}
					}
				} else {
					$('header').removeClass('affix');
				}
			}
			$(window).scroll(function () {
				var scrollTop = $(this).scrollTop();
				addaffix(scrollTop);
			});
			$(window).resize(function () {
				var scrollTop = $(this).scrollTop();
				addaffix(scrollTop);
			});
		</script>
	</div>
</header>