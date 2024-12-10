<footer id="footer">
  <div id="footer-content">
    <div class="footer-content footer-content-top clearfix">
      <div class="container">
        <div class="footer-link-list col-md-5">
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
        <div class="footer-link-list col-md-5">
          <div class="group">
            <h5 class="general-title">Акаунт</h5>
            <ul>
              <li><a href="{{ route('user_settings') }}">Преференции</a></li>
              <li><a href="{{ route('user_account') }}">История на поръчките</a></li>
              <li><a href="{{ route('login') }}">Логин</a></li>
            </ul>
          </div>
        </div>
        <div class="footer-link-list col-md-5">
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
        <div class="footer-link-list col-md-9 ">
          <div class="row">
            <div class="col-md-8 ">
              <a href="/assets/static/pdf/inov-1.pdf" target="_blank" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Европейски фонд за регионално развитие">
                <img src="/assets/static/images/inov-1.jpg"></a>
            </div>
            <div class="col-md-8 ">
              <a href="/assets/static/pdf/inov-2.pdf" target="_blank" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Европейски фонд за регионално развитие">
                <img src="/assets/static/images/inov-2.jpg"></a>
            </div>
            <div class="col-md-8">
              <a href="/assets/static/pdf/inov-3.pdf" target="_blank" class="btooltip swing" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Европейски фонд за регионално развитие">
                <img src="/assets/static/images/inov-3.jpg"></a>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="footer-content footer-content-bottom clearfix">
      <div class="container">
        <div class="copyright col-md-12">
          <a href="./about-us.html">Uvel</a> © {{ date('Y') }}. Всички права запазени!
          <x-store.forms.captcha/>
        </div>
        <div id="widget-payment" class="col-md-12">
          <ul id="payments" class="list-inline animated">
            <li class="btooltip" data-toggle="tooltip" data-placement="top" title="Visa" data-original-title="Visa"><span class="icons visa"></span></li>
            <li class="btooltip" data-toggle="tooltip" data-placement="top" title="Mastercard" data-original-title="Mastercard"><span class="icons mastercard"></span></li>
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