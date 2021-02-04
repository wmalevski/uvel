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
							<p>Вашата заявка бе успешно обработена!<br><br>Ако в системата ни присъства профил обвързан с <b>{{$email}}</b>, ще получите инструкции за смяна на паролата до няколко минути по имейл.</p>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
@endsection