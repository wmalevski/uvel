@extends('store.layouts.app', ['bodyClass' => 'templatePage'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<!-- Content -->
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('stores') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header">
							<h1 id="page-title">Магазини</h1>
						</div>
					</div>
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							<div class="row">

								<div class="left-block col-md-12">
									@foreach($stores as $store)
									<h3>{{ $store->name }}</h3>
									<p>Адрес: {{ $store->location }}</p>
									<p>Телефон: {{ $store->phone }}</p>
									@endforeach
								</div>

								<div class="right-block contact-content col-md-12">
									<h6 class="sb-title">
										<i class="fa fa-home"></i>
										Информация за контакти
									</h6>
									<ul class="right-content contact">
										<li class="title">
											<h6>Адрес на офисите</h6>
										</li>
										<li class="address">
											<i class="fa fa-map-marker"></i>
											София, бул. "Княгиня Мария Луиза" 125
										</li>
										<li class="phone">
											<i class="fa fa-phone"></i>
											+359 888 770 160</li>
										<li class="email">
											<i class="fa fa-envelope"></i>
											uvelgold@gmail.com
										</li>
									</ul>
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
