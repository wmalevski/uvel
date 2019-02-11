@extends('store.layouts.app', ['bodyClass' => 'templateCustomersRegister'])

@section('content')

<div id="content-wrapper-parent">
    <div id="content-wrapper">  
        <!-- Content -->
        <div id="content" class="clearfix">        
            <div id="breadcrumb" class="breadcrumb">
                <div itemprop="breadcrumb" class="container">
                    <div class="row">
                        <div class="col-md-24">
                            {{ Breadcrumbs::render('model_orders') }}
                        </div>
                    </div>
                </div>
            </div>              
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Поръчка</h1> 
                        </div>

 
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection