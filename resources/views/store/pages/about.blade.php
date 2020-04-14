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
                            <h1 id="page-title">История</h1>
                        </div>
                    </div>
                </div>
                <div id="col-main" class="contact-page clearfix">
                    <div class="group-contact clearfix">
                        <div class="container">
                            <div class="row">
                                <div class="left-block col-md-12">
                                    
                                    
                                    <p>Бижутерска къща "UVEL" е семейна фирма, основана през 1990г. в гр.Пазарджик, като продължение на десетилетните златарски и часовникарски традиции на местната фамилия Дечеви.</p>

                                    <p>Притежава собствена работилница с пълен производствен цикъл, два фирмени магазина в град Пазарджик , един в град София и зарежда търговци от цялата страна и чужбина.</p>

                                        <p>Изпълнявала е специални поръчки за бижутерски вериги от Лондон и Париж.</p>

                                            <p>Фирмата се управлява от двама братя Емил Дечев и Владимир Дечев.</p>
                                     
                                </div>
                                <div class="right-block contact-content col-md-12">
                                    <h6 class="sb-title"><i class="fa fa-home"></i> Информация за контакти</h6>
                                    <ul class="right-content">
                                        <li class="title">
                                        <h6>Адрес на офисите</h6>
                                        </li>
                                        <li class="address">
                                        <p>
                                            София, бул. "Княгиня Мария Луиза" 125
                                        </p>
                                        </li><br/>
                                        <li class="phone">+359 888 770 160</li><br/>
                                        <li class="email"><i class="fa fa-envelope"></i> uvelgold@gmail.com </li>
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
