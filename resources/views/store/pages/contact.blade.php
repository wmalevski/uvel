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
							{{ Breadcrumbs::render('contactus') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header">
							<h1 id="page-title">Контакти</h1>
						</div>
					</div>
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							@if($errors->any())
							<ul class="alert alert-danger">
								@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
								@endforeach
							</ul>
							@endif

							@if(session()->has('success'))
							<div class="alert alert-success">
								{{ session()->get('success') }}
							</div>
							@endif

							<div class="row">
								<div class="left-block col-md-12">
									<form method="post" action="contact" class="contact-form" accept-charset="UTF-8">
										{{ csrf_field() }}
										<input type="hidden" value="contact" name="form_type"><input type="hidden" name="utf8" value="✓">
										<ul id="contact-form" class="row list-unstyled">
											<li class="">
												<h3>Напишете ни нещо</h3>
											</li>
											<li class="">
												<label class="control-label" for="name">Вашето име <span class="req">*</span></label>
												<input type="text" id="name" value="" class="form-control" name="name">
											</li>
											<li class="">
												<label class="control-label" for="email">Вашият Email <span class="req">*</span></label>
												<input type="email" id="email" value="" class="form-control email" name="email">
											</li>
											<li class="">
												<label class="control-label" for="message">Съобщение <span class="req">*</span></label>
												<textarea id="message" rows="5" class="form-control" name="message"></textarea>
											</li>
											@captcha
											<li class="unpadding-top">
												<button type="submit" class="btn">Изпратете</button>
											</li>
										</ul>
									</form>
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
									<ul class="right-content social">
										<li class="title">
											<h6>Последвайте ни в</h6>
										</li>
										<li class="facebook">
											<a href="#">
												<span class="fa-stack fa-lg btooltip" title="" data-placement="bottom" data-original-title="Facebook">
													<i class="fa fa-circle fa-stack-2x"></i>
													<i class="fa fa-facebook fa-inverse fa-stack-1x"></i>
												</span>
											</a>
										</li>
										<li class="twitter">
											<a href="#">
												<span class="fa-stack fa-lg btooltip" title="" data-placement="bottom" data-original-title="Twitter">
													<i class="fa fa-circle fa-stack-2x"></i>
													<i class="fa fa-twitter fa-inverse fa-stack-1x"></i>
												</span>
											</a>
										</li>
										<li class="google-plus">
											<a href="#">
												<span class="fa-stack fa-lg btooltip" title="" data-placement="bottom" data-original-title="Google plus">
													<i class="fa fa-circle fa-stack-2x"></i>
													<i class="fa fa-google-plus fa-inverse fa-stack-1x"></i>
												</span>
											</a>
										</li>
										<li class="pinterest">
											<a href="#">
												<span class="fa-stack fa-lg btooltip" title="" data-placement="bottom" data-original-title="Pinterest">
													<i class="fa fa-circle fa-stack-2x"></i>
													<i class="fa fa-pinterest fa-inverse fa-stack-1x"></i>
												</span>
											</a>
										</li>
									</ul>
								</div>

							</div>
						</div>
						{{-- <div id="contact_map_wrapper">
							<div id="contact_map" class="map"></div>
							<script>
								if (jQuery().gMap) {
									if ($('#contact_map').length) {
										$('#contact_map').gMap({
											zoom: 17,
											scrollwheel: false,
											maptype: 'ROADM AP',
											markers: [{
												address: '249 Ung Văn Khiêm, phường 25, Ho Chi Minh City, Vietnam',
												html: '_address'
											}]
										});
									}
								}
							</script>
						</div> --}}
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection