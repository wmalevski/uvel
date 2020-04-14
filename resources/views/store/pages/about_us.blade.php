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
							{{ Breadcrumbs::render('about') }}
						</div>
					</div>
				</div>
			</div>
			<section class="content">
				<div class="container">
					<div class="row">
						<div id="page-header">
							<h1 id="page-title">За Нас</h1>
						</div>
					</div>
				</div>
				<div id="col-main" class="contact-page clearfix">
					<div class="group-contact clearfix">
						<div class="container">
							<div class="row">
								<div class="left-block col-md-12">

									<h3>За Нас</h3>
									<p>Бижутерска къща "UVEL" е семейна фирма, основана през 1990г. в гр.Пазарджик, като продължение на
										десетилетните златарски и часовникарски традиции на местната фамилия Дечеви.</p>

									<p>Притежава собствена работилница с пълен производствен цикъл, два фирмени магазина в град Пазарджик , един в
										град София и зарежда търговци от цялата страна и чужбина.</p>

									<p>Изпълнявала е специални поръчки за бижутерски вериги от Лондон и Париж.</p>

									<p>Фирмата се управлява от двама братя Емил Дечев и Владимир Дечев.</p>

									<h3>Гаранция</h3>

									<p>Уважаеми клиенти,
										Вашето бижу е проверено и маркирано с
										държавен знак от специализирана лабора тория към Министерство на финансите.</p>

									<p>"Uvel" поема едногодишна гаранция и безплатен ремонт за всички свои изделия, освен в случай на очевидна
										външна интервенция.</p>

									<p>Указаното тегло на златните изделия е чисто, от него е подваден грамажа на камъните.</p>

									<p>Благодарим Ви, че избирате бижутата на "Uvel"!</p>


									<p>UVEL дава 1 година гаранция</p>

									<h3>Цени</h3>

									<p>ОБРАБОТЕНО ЗЛАТО 14 карата (585)-средна цена : 68-78 лв/гр.</p>

									<p>Единичната цена на всяко бижу зависи от сложността на изработката</p>


									<p>ОБМЯНА: грам за грам + доплащане на изработката</p>

									<p>СРЕДНА ИЗРАБОТКА : 24лв/гр.</p>


									<p>"UVEL" продава ЧИСТО ТЕГЛО на златото</p>

									<p>Теглото на всички камъни е подвадено от грамажа на изделията</p>


									<p>ИЗКУПУВАНЕ на злато(материал) = 38 лв/гр.</p>

									<p>Цени на международни борси: www.kitco.com</p>


									<p>Цени на ремонти тук</p>


									<p>UVEL дава 1 година гаранция!</p>

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
