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
                            {{ Breadcrumbs::render('contactus') }}
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
                                            249 Ung Van Khiem Street, Binh Thanh Dist, HCM city
                                        </p>
                                        </li>
                                        <li class="phone">+84 0123456xxx</li>
                                        <li class="email"><i class="fa fa-envelope"></i> support@designshopify.com</li>
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