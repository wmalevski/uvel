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
                            <a href="./index.html" class="homepage-link" title="Back to the frontpage">Начало</a>
                            <span>/</span>
                            <span class="page-title">Поръчки</span>
                        </div>
                    </div>
                </div>
            </div>              
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Поръчки</h1> 
                        </div>

                        <div id="col-main" class="col-md-24 register-page clearfix">
                           <table class="table">
                                
                           </table>
                        </div>   
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection