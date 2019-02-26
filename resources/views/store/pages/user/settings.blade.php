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
                            {{ Breadcrumbs::render('settings') }}
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container">
                    <div class="row">
                        <div id="page-header" class="col-md-24">
                            <h1 id="page-title">Настройки</h1>
                        </div>

                        <div id="col-main" class="col-md-24 register-page clearfix">
                            <form method="POST" action="{{ route('user_settings_update') }}" id="create_customer" accept-charset="UTF-8">
                                {{ csrf_field() }}
                                <input value="create_customer" name="form_type" type="hidden"><input name="utf8" value="✓" type="hidden">
                                <ul id="register-form" class="row list-unstyled">
                                    <li class="clearfix"></li>
                                    <li id="last_namef">
                                    <label class="control-label" for="name">Потребителско име</label>
                                    <input name="name" id="name" class="form-control " value="{{$user->name}}" type="text" readonly>
                                    </li>
                                    <li class="clearfix"></li>
                                    <li id="emailf" class="">
                                    <label class="control-label" for="email">Email <span class="req">*</span></label>
                                    <input name="email" id="email" class="form-control " value="{{ $user->email }}" type="email" readonly>
                                    </li>

                                    <li id="first_name" class="">
                                        <label class="control-label" for="first_name">Име <span class="req">*</span></label>
                                        <input name="first_name" id="first_name" value="{{ $user->first_name }}" class="form-control " type="text">
                                    </li>

                                    <li id="last_name" class="">
                                        <label class="control-label" for="last_name">Фамилия <span class="req">*</span></label>
                                        <input name="last_name" id="last_name" value="{{ $user->last_name }}" class="form-control " type="text">
                                    </li>

                                    <li id="city" class="">
                                            <label class="control-label" for="city">Град <span class="req">*</span></label>
                                            <input name="city" id="city" class="form-control " value="{{ $user->city }}" type="text">
                                        </li>


                                    <li id="street" class="">
                                        <label class="control-label" for="street">Улица <span class="req">*</span></label>
                                        <input name="street" id="street" value="{{ $user->street }}" class="form-control " type="text">
                                    </li>


                                    <li id="street_number" class="">
                                        <label class="control-label" for="street_number">Номер <span class="req">*</span></label>
                                        <input name="street_number" value="{{ $user->street_number }}" id="street_number" class="form-control " type="text">
                                    </li>


                                    <li id="country" class="">
                                        <label class="control-label" for="country">Държава <span class="req">*</span></label>
                                        <input name="country" id="country" value="{{ $user->country }}" class="form-control " type="text">
                                    </li>

                                    <li id="postcode" class="">
                                        <label class="control-label" for="postcode">Пощенски код <span class="req">*</span></label>
                                        <input name="postcode" id="postcode" value="{{ $user->postcode }}" class="form-control " type="text">
                                    </li>

                                    <li id="phone" class="">
                                        <label class="control-label" for="phone">Телефон <span class="req">*</span></label>
                                        <input name="phone" id="phone" value="{{ $user->phone }}" class="form-control " type="tel">
                                    </li>


                                    <li id="passwordf" class="">
                                        <label class="control-label" for="password">Стара Парола <span class="req">*</span></label>
                                        <input value="" name="old_password" id="password" class="form-control password" type="password">
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
                                    <button class="btn" type="submit">Обнови</button>
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