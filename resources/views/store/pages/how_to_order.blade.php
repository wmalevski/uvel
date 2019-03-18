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
                            {{ Breadcrumbs::render('howtoorder') }}
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header">
                            <h1 id="page-title">Поръчка на бижу</h1>
                        </div>
                    </div>
                </div>
                <div id="col-main" class="contact-page clearfix">
                    <div class="group-contact clearfix">
                        <div class="container">
                            <div class="row">
                                <div class="left-block col-md-12">
                                    <p>1. Кликнете върху снимката на избраното бижу за увеличен изглед.</p>
                                    <p>2. Натиснете надпис ПОРЪЧАЙ или ДОБАВИ В КОЛИЧКА.</p>
                                    <p>3. Направете регистрация, ако нямате отпреди и продължете към форма за поръчка.</p>
                                    <p>4. Попълнете задължителните полета на формата.</p>
                                    <p>5. Изпратете формата.</p>
                                    <p>6. Излиза потвърдителен надпис за успешно изпращане.</p>
                                    <p>7. С Вас ще се свърже служител на фирмата за лично потвърждение на поръчката.</p>
                                    <p>8. Поръчката ще бъде изпратена по куриер с/у наложен платеж или взета от наш обект, според Вашето желание.</p>
                                    <p>Фирма "UVEL" ще Ви върне парите, ако не сме удовлетворили всички Ваши изисквания!</p>
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
