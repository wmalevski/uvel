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
							<form method="POST" action="{{ route('password_reset') }}" id="password_reset" accept-charset="UTF-8">
								{{ csrf_field() }}
								<input value="password_reset" name="form_type" type="hidden" />
								<ul id="reset-form" class="row list-unstyled">
									<li class="clearfix"></li>
									<li class="clearfix"></li>
									<li>
										<p>Въведете имейл адреса за Вашият акаунт и ще Ви изпратим инструкции как да смените парола за вашия профил</p>
									</li>
									<li class="clearfix"></li>
									<li class="clearfix"></li>
									<li id="emailf" class="">
										<label class="control-label" for="email">Имейл <span class="req">*</span></label>
										<input name="email" id="email" class="form-control " type="text" />
									</li>
									<li class="clearfix"></li>
									<li class="clearfix"></li>
									<li class="unpadding-top action-last">
										<button class="btn" type="submit">Изпрати</button>
									</li>
								</ul>
							</form>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection