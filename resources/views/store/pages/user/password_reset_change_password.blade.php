@extends('store.layouts.app', ['bodyClass' => 'templateCustomersRegister'])
@section('content')
<div id="content-wrapper-parent">
	<div id="content-wrapper">
		<!-- Content -->
		<div id="content" class="clearfix">
			<div id="breadcrumb" class="breadcrumb"><div itemprop="breadcrumb" class="container"></div></div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header" class="col-md-24"><h1 id="page-title">Забравена Парола</h1></div>
						<div id="col-main" class="col-md-24 register-page clearfix">
						@if($invalid_token)
							<p>Този линк е невалиден или изтекъл!<br>
							Моля опитайте отново чрез <a href="{{ route('password_reset') }}" target="_self">тази форма</a></p>
						@else
							<div class="col-md-6"></div>
							<div class="col-md-12">
								<form method="post" action="{{ route('password_reset_validate', $token) }}" class="password_reset_form" accept-charset="UTF-8" data-form-captcha>
									{{ csrf_field() }}
									<input type="hidden" value="password_reset_form" name="form_type" />
									<div id="contact_captcha" data-size="invisible" data-captcha="contact_captcha" data-callback="formSubmit"></div>
									<ul id="contact-form" class="row list-unstyled">
										<li><p>Моля попълнете новата парола за профила си</p></li>
										<li>
											<label class="control-label" for="password">Нова парола<span class="req">*</span></label>
											<input type="password" id="password" value="" class="form-control" name="password" required />
										</li>
										<li>
											<label class="control-label" for="password_confirm">Потвърди паролата <span class="req">*</span></label>
											<input type="password" id="password_confirm" value="" class="form-control" name="password_confirm" required />
										</li>
										<li class="unpadding-top"><button type="submit" class="btn">Запази</button></li>
									</ul>
								</form>
							</div>
							<div class="col-md-6"></div>
						@endif
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection