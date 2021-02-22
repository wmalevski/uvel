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
					@if(session()->get('success'))
						<div class="row">
							<div class="col-md-12">
								<div class="alert alert-success">
									{{ session()->get('success')['contact'] }}
								</div>
							</div>
						</div>
					@endif
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							<div class="row">
								<div class="left-block col-md-12">
									<form method="post" action="contact" class="contact-form" accept-charset="UTF-8" data-form-captcha>
										{{ csrf_field() }}
										<input type="hidden" value="contact" name="form_type"><input type="hidden" name="utf8" value="✓">
										<div 
											id="contact_captcha"
											data-size="invisible" data-captcha="contact_captcha" data-callback="formSubmit">
										</div>
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

											<li class="unpadding-top">
												<button type="submit" class="btn">Изпратете</button>
											</li>
                      <li>
                        <small class="g-recaptcha-notice-text">
                          This site is protected by reCAPTCHA and the Google
                          <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                          <a href="https://policies.google.com/terms">Terms of Service</a> apply.
                        </small>
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
