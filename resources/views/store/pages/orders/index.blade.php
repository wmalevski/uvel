@extends('store.layouts.app', ['bodyClass' => 'templatePage'])

@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb">
				<div itemprop="breadcrumb" class="container">
					<div class="row">
						<div class="col-md-24">
							{{ Breadcrumbs::render('custom_order') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header">
							<h1 id="page-title">Поръчка по ваш модел </h1>
						</div>
					</div>
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							<div class="row">
								<div class="left-block col-md-12">
									<form method="post" action="{{ route('submit_custom_order') }}" data-form-captcha class="contact-form customOrder-form"
									 accept-charset="UTF-8">
										{{ csrf_field() }}
										<input type="hidden" value="contact" name="form_type">
										<input type="hidden" name="utf8" value="✓">
										<div 
											id="custom_order"
											data-size="invisible" data-captcha="custom_order" data-callback="submitCustomOrder">
										</div>
										<ul id="contact-form" class="row list-unstyled">
											<li class="">
												<h3>Използвайте формата, за да поръчате бижу по Ваши изисквания</h3>
											</li>
											<li class="">
												<label class="control-label" for="name">
													Вашето име
													<span class="req">*</span>
												</label>
												<input type="text" id="name" value="" class="form-control" name="name">
											</li>
											<li class="clearfix"></li>
											<li class="">
												<label class="control-label" for="email">
													Вашият Email
													<span class="req">*</span>
												</label>
												<input type="email" id="email" value="" class="form-control email" name="email">
											</li>
											<li class="">
												<label class="control-label" for="city">
													Град
													<span class="req">*</span>
												</label>
												<input type="text" id="city" value="" class="form-control email" name="city">
											</li>

											<li class="">
												<label class="control-label" for="phone">
													Телефон
													<span class="req">*</span>
												</label>
												<input type="tel" id="phone" value="" class="form-control email" name="phone">
											</li>
											<li class="clearfix"></li>
											<li class="">
												<label class="control-label" for="message">
													Описание
													<span class="req">*</span>
												</label>
												<textarea id="message" rows="5" class="form-control" name="content"></textarea>
											</li>
											<li>
												<label class="control-label">Снимки</label>
												<div class="drop-area" name="add">
													<input type="file" name="images" class="drop-area-input" id="fileElem-add" accept="image/*">
													<label class="button" for="fileElem-add">
														Качи снимка
													</label>
													<div class="drop-area-gallery"></div>
												</div>
											</li>
											<li class="clearfix"></li>
											<li class="unpadding-top">
												<button type="submit" class="btn">
													Изпратете запитване
												</button>
                        
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
											<h6>Адрес на магазин</h6>
										</li>
										<li class="address">
											<i class="fa fa-map-marker"></i>
											гр.София, бул."Княгиня Мария-Луиза" 125
										</li>
										<li class="phone">
											<i class="fa fa-phone"></i>
											+359 888 770 160 - дизайнер
										</li>
										<li class="phone">
											<i class="fa fa-phone"></i>
											+359 887 957 766 - магазин
										</li>
										<li class="email">
											<i class="fa fa-envelope"></i>
											uvelgold@gmail.com
										</li>
										<li>
											------------------------------------
										</li
										<li class="title">
										<h6>
											<i class="fa fa-cog  fa-1x"></i>	
											Работно време на магазините
										</h6>
										</li>
										<li>											
											Понеделник - петък: 9:30 - 18:30
										</li>
										<li>											
											Събота: 10:00 - 15:00
										</li>
										<li>											
											Неделя: почивен ден
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
