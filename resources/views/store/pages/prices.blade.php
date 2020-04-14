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
                            {{ Breadcrumbs::render('prices') }}
                        </div>
                    </div>
                </div>
            </div>               
            <section class="content">    
                <div class="container">
                    <div class="row">
                        <div id="page-header">
                            <h1 id="page-title">Цени</h1>
                        </div>
                    </div>
                </div>
                <div id="col-main" class="contact-page clearfix">
                    <div class="group-contact clearfix">
                        <div class="container">
                            <div class="row">
                                <div class="left-block col-md-12">
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
