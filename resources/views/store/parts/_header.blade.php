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
							@auth
								<li class="login">
									<a href="{{ route('user_account') }}" id="customer_register_link">{{ Auth::user()->email }}</a>
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
											<a href="@if (Auth::check()) {{ route('user_account') }} @else {{ route('login') }} @endif ">
												<i class="fa fa-user"></i>
											</a>
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
											@foreach($materialTypes as $material => $type)
												<li  class="{{ filter_products('byMaterial', $type->id) }}">
													<a tabindex="-1" href="{{ route('products') }}?
													@foreach(\App\Material::where('parent_id', $type->id)->get() as $material_type => $current_type)byMaterial[]={{trim($current_type->id)}}
														@if(1 + $material_type < count(\App\Material::where('parent_id', $type->id)->get()))& @else &listType=goGrid @endif
													@endforeach">
														{{ $type->name }}
													</a>
												</li>
											@endforeach

											@foreach($productothertypes as $type)
												<li class="">
													<a tabindex="-1" href="{{ route('productsothers') }}?byType[]={{ $type->id }}">
														{{ $type->name }}
													</a>
												</li>
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
				</li>
				<li class="umbrella hidden-xs">
					<div id="umbrella" class="navbar list-inline unmargin">
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
											{{ Cart::session(Session::getId())->getTotalQuantity() }}
											@endif
										</span>
									</span>
								</div>
							</a>
						</div>
					</div>
				</li>
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
	@if($errors->any())
		<div class="info-message error">
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</div>
	@elseif(session()->has('success'))
		<div class="info-message success">
			{{ session()->get('success->first()') }}
		</div>
	@endif
</header>