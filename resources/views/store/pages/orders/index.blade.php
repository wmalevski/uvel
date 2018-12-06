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
                            {{ Breadcrumbs::render('custom_order') }}
                        </div>
                    </div>
                </div>
            </div>               
            <section class="content">    
                <div class="container">
                    <div class="row">
                        <div id="page-header">
                            <h1 id="page-title">Поръчка по модел на клиента</h1>
                        </div>
                    </div>
                </div>
                <div id="col-main" class="contact-page clearfix">
                    <div class="group-contact clearfix">
                        <div class="container">
                            @if($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif 

                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="left-block col-md-12">
                                    <form method="post" action="{{ route('submit_custom_order') }}" class="contact-form customOrder-form" accept-charset="UTF-8">  
                                        {{ csrf_field() }}
                                        <input type="hidden" value="contact" name="form_type"><input type="hidden" name="utf8" value="✓">
                                        <ul id="contact-form" class="row list-unstyled">
                                            <li class="">
                                            <h3>Можете да използвате формата за да поръчате продукт по ваши изисквания</h3>
                                            </li>
                                            <li class="">
                                            <label class="control-label" for="name">Вашето име <span class="req">*</span></label>
                                            <input type="text" id="name" value="" class="form-control" name="name">
                                            </li>
                                            <li class="clearfix"></li>
                                            <li class="">
                                            <label class="control-label" for="email">Вашият Email <span class="req">*</span></label>
                                            <input type="email" id="email" value="" class="form-control email" name="email">
                                            </li>
                                            <li class="">
                                                <label class="control-label" for="city">Град <span class="req">*</span></label>
                                                <input type="text" id="city" value="" class="form-control email" name="city">
                                            </li>

                                            <li class="">
                                                <label class="control-label" for="phone">Телефон <span class="req">*</span></label>
                                                <input type="tel" id="phone" value="" class="form-control email" name="phone">
                                            </li>
                                            <li class="clearfix"></li>
                                            <li class="">
                                                <label class="control-label" for="message">Описание <span class="req">*</span></label>
                                                <textarea id="message" rows="5" class="form-control" name="content"></textarea>
                                            </li>
                                            <li>
                                                <label class="control-label">Снимки</label>
                                                <div class="drop-area" name="add">
                                                    <input type="file" name="images" class="drop-area-input" id="fileElem-add" accept="image/*" >
                                                    <label class="button" for="fileElem-add">Качи снимка</label>
                                                    <div class="drop-area-gallery"></div>
                                                </div>
                                            </li>
                                            <li class="clearfix"></li>
                                            @captcha    
                                            <li class="unpadding-top">
                                                <button type="submit" class="btn">Изпратете запитване</button>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                                <div class="right-block contact-content col-md-12">
                                    <h6 class="sb-title"><i class="fa fa-home"></i> Информация за клиента</h6>
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
                    </div>
                </div> 
            </section>        
        </div>
    </div>
</div>
@endsection