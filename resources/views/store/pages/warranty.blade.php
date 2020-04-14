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
                            {{ Breadcrumbs::render('warranty') }}
                        </div>
                    </div>
                </div>
            </div>               
            <section class="content">    
                <div class="container">
                    <div class="row">
                        <div id="page-header">
                            <h1 id="page-title">Гаранция</h1>
                        </div>
                    </div>
                </div>
                <div id="col-main" class="contact-page clearfix">
                    <div class="group-contact clearfix">
                        <div class="container">
                            <div class="row">
                                <div class="left-block col-md-12">
                                    
                                    <p>Уважаеми клиенти,
                                    Вашето бижу е проверено и маркирано с
                                    държавен знак от специализирана лабора тория към Министерство на финансите.</p>
                                    
                                        <p>"Uvel" поема едногодишна гаранция и безплатен ремонт за всички свои изделия, освен в случай на очевидна външна интервенция.</p>
                                    
                                            <p>Указаното тегло на златните изделия е чисто, от него е подваден грамажа на камъните.</p>
                                    
                                                <p>Благодарим Ви, че избирате бижутата на "Uvel"!</p>
                                    
                                    
                                                    <p>UVEL дава 1 година гаранция</p>
                                     
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
