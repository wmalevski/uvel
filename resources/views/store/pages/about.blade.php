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
                                    <ul class="right-content">
                                        <li class="title">
                                        <h6>Последвайте ни в</h6>
                                        </li>
                                        <li class="facebook"><a href="#"><span class="fa-stack fa-lg btooltip" title="" data-original-title="Facebook"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-facebook fa-inverse fa-stack-1x"></i></span></a></li>
                                        <li class="twitter"><a href="#"><span class="fa-stack fa-lg btooltip" title="" data-original-title="Twitter"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-twitter fa-inverse fa-stack-1x"></i></span></a></li>
                                        <li class="google-plus"><a href="#"><span class="fa-stack fa-lg btooltip" title="" data-original-title="Google plus"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-google-plus fa-inverse fa-stack-1x"></i></span></a></li>
                                        <li class="pinterest"><a href="#"><span class="fa-stack fa-lg btooltip" title="" data-original-title="Pinterest"><i class="fa fa-circle fa-stack-2x"></i><i class="fa fa-pinterest fa-inverse fa-stack-1x"></i></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        {{-- <div id="contact_map_wrapper">
                            <div id="contact_map" class="map"></div>
                            <script>
                            if(jQuery().gMap){
                                if($('#contact_map').length){
                                    $('#contact_map').gMap({
                                    zoom: 17,
                                    scrollwheel: false,
                                    maptype: 'ROADM AP',
                                    markers:[
                                        {
                                        address: '249 Ung Văn Khiêm, phường 25, Ho Chi Minh City, Vietnam',
                                        html: '_address'
                                        }
                                    ]
                                    });
                                }
                            }
                            </script>
                        </div> --}}
                    </div>
                </div> 
            </section>        
        </div>
    </div>
</div>
@endsection