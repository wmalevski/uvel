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
                            <a href="./index.html" class="homepage-link" title="Back to the frontpage">Home</a>
                            <span>/</span>
                            <span class="page-title">Create Account</span>
                        </div>
                    </div>
                </div>
            </div>              
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Регистрация</h1> 
                        </div>

                        <div id="col-main" class="col-md-24 register-page clearfix">
                            @if($errors->any())
                                <ul class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif 

                            <form method="POST" action="{{ route('registerform') }}" id="create_customer" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <input value="create_customer" name="form_type" type="hidden"><input name="utf8" value="✓" type="hidden">
                                <ul id="register-form" class="row list-unstyled">
                                    <li class="clearfix"></li>
                                    <li id="last_namef">
                                    <label class="control-label" for="name">Име</label>
                                    <input name="name" id="name" class="form-control " type="text">
                                    </li>
                                    <li class="clearfix"></li>
                                    <li id="emailf" class="">
                                    <label class="control-label" for="email">Email <span class="req">*</span></label>
                                    <input name="email" id="email" class="form-control " type="email">
                                    </li>
                                    <li class="clearfix"></li>
                                    <li id="passwordf" class="">
                                    <label class="control-label" for="password">Парола <span class="req">*</span></label>
                                    <input value="" name="password" id="password" class="form-control password" type="password">
                                    </li>
                                    <li id="password_repear" class="">
                                        <label class="control-label" for="password_confirmation">Повтори паролата <span class="req">*</span></label>
                                        <input value="" name="password_confirmation" id="password_confirmation" class="form-control password" type="password">
                                        </li>
                                    <li class="clearfix"></li>
                                    <li class="unpadding-top action-last">
                                    <button class="btn" type="submit">Регистрирай се</button>
                                    </li>
                                </ul>
                            </form>
                        </div>   
                    </div>
                </div>
            </section>        
        </div>
    </div>
</div>
@endsection