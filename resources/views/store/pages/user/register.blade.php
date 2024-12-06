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
                            {{ Breadcrumbs::render('register') }}
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
                            <form method="POST" action="{{ route('registerform') }}" data-form-captcha id="create_customer" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <input value="create_customer" name="form_type" type="hidden"><input name="utf8" value="✓" type="hidden">
                                <div 
                                  id="create_customer_captcha"
                                  data-size="invisible" data-captcha="create_customer_captcha" data-callback="formSubmit">
                                </div>

                                <ul id="register-form" class="row list-unstyled">
                                    <li class="clearfix"></li>
                                    <li id="emailf" class="">
                                    <label class="control-label" for="email">Email <span class="req">*</span></label>
                                    <input name="email" id="email" class="form-control " type="email"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->email }} @endif">
                                    </li>

                                    <li id="first_name" class="">
                                        <label class="control-label" for="first_name">Име <span class="req">*</span></label>
                                        <input name="first_name" id="first_name" class="form-control " type="text"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->first_name }} @endif">
                                    </li>

                                    <li id="last_name" class="">
                                        <label class="control-label" for="last_name">Фамилия <span class="req">*</span></label>
                                        <input name="last_name" id="last_name" class="form-control " type="text"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->last_name }} @endif">
                                    </li>

                                    <li id="city" class="">
                                            <label class="control-label" for="city">Град <span class="req">*</span></label>
                                            <input name="city" id="city" class="form-control " type="text"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->city }} @endif">
                                        </li>


                                    <li id="street" class="">
                                        <label class="control-label" for="street">Улица <span class="req">*</span></label>
                                        <input name="street" id="street" class="form-control " type="text" value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->street }} @endif">
                                    </li>


                                    <li id="street_number" class="">
                                        <label class="control-label" for="street_number">Номер <span class="req">*</span></label>
                                        <input name="street_number" id="street_number" class="form-control " type="text" value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->street_number }} @endif">
                                    </li>


                                    <li id="country" class="">
                                        <label class="control-label" for="country">Държава <span class="req">*</span></label>
                                        <input name="country" id="country" class="form-control " type="text" value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->country }} @else България @endif">
                                    </li>

                                    <li id="postcode" class="">
                                        <label class="control-label" for="postcode">Пощенски код <span class="req">*</span></label>
                                        <input name="postcode" id="postcode" class="form-control " type="text"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->postcode }} @endif">
                                    </li>

                                    <li id="phone" class="">
                                        <label class="control-label" for="phone">Телефон <span class="req">*</span></label>
                                        <input name="phone" id="phone" class="form-control " type="tel"  value="@if(isset($_COOKIE['register_data'])) {{ json_decode($_COOKIE['register_data'])->phone }} @endif">
                                    </li>


                                    <li class="clearfix"></li>
                                    <li id="passwordf" class="">
                                    <label class="control-label" for="password">Парола (Минимум 6 символа)<span class="req">*</span></label>
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