<footer id="footer">
	<div id="footer-content">
		<!--
		<h6 class="general-title contact-footer-title">Абониране</h6>
		<div id="widget-newsletter">
			<div class="container">
				<div class="newsletter col-md-24">
					<form action="{{ route('subscribe') }}" method="POST" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" data-form-captcha>
						{{ csrf_field() }}
						<span class="news-desc">Обещаваме, че изпращаме само най-доброто</span>
						<div class="group_input">
							<input class="form-control" type="email" placeholder="Вашият имейл адрес" name="email" id="email-input">
							<div class="unpadding-top">
								<div
									id="subscribe_captcha"
									data-size="invisible" data-captcha="subscribe_captcha" data-callback="formSubmit">
								</div>
								<button class="btn btn-1" type="submit">
									<i class="fa fa-paper-plane"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
		-->

		<div class="footer-content footer-content-top clearfix">
			<div class="container">
				<div class="footer-link-list col-md-8">
					<div class="group">
						<h5 class="general-title">Информация</h5>
						<ul>
							<li><a href="{{ route('online_stores') }}">Магазини</a></li>
							<li><a href="{{ route('privacy_policy') }}">Политика за поверителност</a></li>
							<li><a href="{{ route('cookies_policy') }}">Политика за бисквитки</a></li>
							<li><a href="./account.html">Карта на сайта</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-link-list col-md-8">
					<div class="group">
						<h5 class="general-title">Акаунт</h5>
						<ul>
							<li><a href="{{ route('user_settings') }}">Преференции</a></li>
							<li><a href="{{ route('user_account') }}">История на поръчките</a></li>
							<li><a href="{{ route('login') }}">Логин</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-link-list col-md-6">
					<div class="group">
						<h5 class="general-title">За нас</h5>
						<ul>
							<li><a href="{{ route('contactus') }}">Контакт</a></li>
							<li><a href="{{ route('about') }}">За нас</a></li>
							<li>
								<a target="_blank" href="{{ App\Setting::get('facebook_link') }}" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title=""
									data-original-title="Facebook">
								 	<i class="fa fa-lg fa-facebook"></i>
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-content footer-content-bottom clearfix">
			<div class="container">
				<div class="copyright col-md-12">
					<a href="./about-us.html">Uvel</a> © {{ date('Y') }}. Всички права запазени!
				</div>
				<div id="widget-payment" class="col-md-12">
					<ul id="payments" class="list-inline animated">
						<li class="btooltip" data-toggle="tooltip" data-placement="top" title="Visa" data-original-title="Visa"><span class="icons visa"></span></li>
						<li class="btooltip" data-toggle="tooltip" data-placement="top" title="Mastercard" data-original-title="Mastercard"><span class="icons mastercard"></span></li>
						<!-- <li class="btooltip" data-toggle="tooltip" data-placement="top" title="American Express" data-original-title="American Express"><span class="icons amex"></span></li>
						<li class="btooltip" data-toggle="tooltip" data-placement="top" title="Paypal" data-original-title="Paypal"><span class="icons paypal"></span></li> -->
					</ul>
				</div>
			</div>
		</div>
	</div>
</footer>

<div id="quick-shop-modal" class="modal in" role="dialog" aria-hidden="false" tabindex="-1" data-width="800">
	<div class="modal-backdrop in" style="height: 742px;">
	</div>
	<div class="modal-dialog rotateInDownLeft animated">
		<div class="modal-content">

		</div>
	</div>
</div>
