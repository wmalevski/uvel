<footer id="footer">      
    <div id="footer-content">
        <h6 class="general-title contact-footer-title">Абониране</h6>  
        <div id="widget-newsletter">
            <div class="container">            
                <div class="newsletter col-md-24">
                <form action="{{ route('subscribe') }}" method="POST" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form">
                        {{ csrf_field() }}
                    <span class="news-desc">Обещаваме, че пращаме само най-доброто</span>
                    <div class="group_input">
                    <input class="form-control" type="email" placeholder="Вашият Email Адрес" name="email" id="email-input">
                    <div class="unpadding-top">
                        <button class="btn btn-1" type="submit"><i class="fa fa-paper-plane"></i></button></div>
                    </div>   
                    @captcha      
                </form>
                </div>						
            </div>
        </div>
        
        <div class="footer-content footer-content-top clearfix">
            <div class="container">
                <div class="footer-link-list col-md-6">
                    <div class="group">
                    <h5 class="general-title">За нас</h5>						
                    <ul class="list-unstyled list-styled">						  
                        <li class="list-unstyled">
                        <a href="./account.html">Гарация</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html">Цени</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html">Контакт</a>
                        </li>						  						  
                    </ul>
                    </div>
                </div>   
                <div class="footer-link-list col-md-6">
                    <div class="group">
                    <h5 class="general-title">Информация</h5>						
                    <ul class="list-unstyled list-styled">						  
                        <li class="list-unstyled">
                        <a href="./account.html">Магазини</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html">Политика за поверителност</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html"Карта на сайта</a>
                        </li>						  					  
                    </ul>
                    </div>
                </div>
                <div class="footer-link-list col-md-6">
                    <div class="group">
                    <h5 class="general-title">Акаунт</h5>						
                    <ul class="list-unstyled list-styled">						  
                        <li class="list-unstyled">
                        <a href="./account.html">Преференции</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html">История на поръчките</a>
                        </li>						  
                        <li class="list-unstyled">
                        <a href="./account.html">Логин</a>
                        </li>						  					  
                    </ul>
                    </div>
                </div>
                <div class="footer-link-list col-md-6">
                    <div class="group">
                    <h5 class="general-title">Клиенти</h5>						
                    <ul class="list-unstyled list-styled">						  
                        <li class="list-unstyled">
                            <a href="./search.html">Search Advanced</a>
                        </li>						  
                        <li class="list-unstyled">
                            <a href="#">Return Policy</a>
                        </li>						  
                        <li class="list-unstyled">
                            <a href="#">Privacy Policy</a>
                        </li>						  
                        <li class="list-unstyled">
                            <a href="#">Help &amp; Contact</a>
                        </li>						  
                    </ul>
                    </div>
                </div>   
            </div>
        </div>
        <div class="footer-content footer-content-bottom clearfix">
            <div class="container">
                <div class="copyright col-md-12">
                    © 2018 <a href="./about-us.html">Uvel</a>. Всички права запазени!
                </div>
                <div id="widget-payment" class="col-md-12">
                    <ul id="payments" class="list-inline animated">
                        <li class="btooltip tada" data-toggle="tooltip" data-placement="top" title="" data-original-title="Visa"><a href="#" class="icons visa"></a></li>
                        <li class="btooltip tada" data-toggle="tooltip" data-placement="top" title="" data-original-title="Mastercard"><a href="#" class="icons mastercard"></a></li>
                        <li class="btooltip tada" data-toggle="tooltip" data-placement="top" title="" data-original-title="American Express"><a href="#" class="icons amex"></a></li>
                        <li class="btooltip tada" data-toggle="tooltip" data-placement="top" title="" data-original-title="Paypal"><a href="#" class="icons paypal"></a></li>
                        <li class="btooltip tada" data-toggle="tooltip" data-placement="top" title="" data-original-title="Moneybookers"><a href="#;" class="icons moneybookers"></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>   
</footer>
	
{{-- <div class="newsletter-popup" style="display: none;">
    <form action="http://codespot.us5.list-manage.com/subscribe/post?u=ed73bc2d2f8ae97778246702e&amp;id=c63b4d644d" method="post" name="mc-embedded-subscribe-form" target="_blank">
        <h4>-50% Deal</h4>
        <p class="tagline">
            subscribe for newsletter and get the item for 50% off
        </p>
        <div class="group_input">
            <input class="form-control" type="email" name="EMAIL" placeholder="YOUR EMAIL">
            <button class="btn" type="submit"><i class="fa fa-paper-plane"></i></button>
        </div>
    </form>
    <div id="popup-hide">
        <input type="checkbox" id="mc-popup-hide" value="1" checked="checked"><label for="mc-popup-hide">Never show this message again</label>
    </div>
</div> --}}
	
<div id="quick-shop-modal" class="modal in" role="dialog" aria-hidden="false" tabindex="-1" data-width="800">
    <div class="modal-backdrop in" style="height: 742px;">
    </div>
    <div class="modal-dialog rotateInDownLeft animated">
        <div class="modal-content">
            
        </div>
    </div>
</div>