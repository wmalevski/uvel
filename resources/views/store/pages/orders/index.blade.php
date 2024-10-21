@php

$username = '';
$useremail = '';
$usercity = '';
$userphone = '';

if (Auth::check()) {
  $user = Auth::user();
  $username = $user->first_name . ' ' . $user->last_name;
  $useremail = $user->email;
  $usercity = $user->city;
  $userphone = $user->phone;
}
@endphp

@extends('store.layouts.app', ['bodyClass' => 'templatePage'])
@section('content')
<div id="content-wrapper-parent">
  <div id="content-wrapper">
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
              <h1 id="page-title">Поръчка по ваш модел </h1>
            </div>
          </div>
        </div>
        <div id="col-main" class="contact-page clearfix">
          <div class="group-contact clearfix">
            <div class="container">
              <div class="row">
                <div class="left-block col-md-12">
                  <form method="post"
                    action="{{ route('submit_custom_order') }}"
                    {{-- data-form-captcha --}}
                    class="contact-form customOrder-form"
                    accept-charset="UTF-8"
                    enctype="multipart/form-data"
                  >
                    {{ csrf_field() }}
                    <input type="hidden" value="contact" name="form_type">
                    <input type="hidden" name="utf8" value="✓">
                    <div 
                      id="custom_order"
                      data-size="invisible" data-captcha="custom_order" data-callback="submitCustomOrder">
                    </div>
                    <ul id="contact-form" class="row list-unstyled">
                      <li class="">
                        <h3>Използвайте формата, за да поръчате бижу по Ваши изисквания</h3>
                      </li>
                      <li class="">
                        <label class="control-label" for="name">
                          Вашето име
                          <span class="req">*</span>
                        </label>
                        <input type="text" id="name" value="{{$username}}" class="form-control" name="name">
                      </li>
                      <li class="clearfix"></li>
                      <li class="">
                        <label class="control-label" for="email">
                          Вашият Email
                          <span class="req">*</span>
                        </label>
                        <input type="email" id="email" value="{{$useremail}}" class="form-control email" name="email">
                      </li>
                      <li class="">
                        <label class="control-label" for="city">
                          Град
                          <span class="req">*</span>
                        </label>
                        <input type="text" id="city" value="{{$usercity}}" class="form-control email" name="city">
                      </li>

                      <li class="">
                        <label class="control-label" for="phone">
                          Телефон
                          <span class="req">*</span>
                        </label>
                        <input type="tel" id="phone" value="{{$userphone}}" class="form-control email" name="phone">
                      </li>
                      <li class="clearfix"></li>
                      <li class="">
                        <label class="control-label" for="message">
                          Описание
                          <span class="req">*</span>
                        </label>
                        <textarea id="message" rows="5" class="description form-control" name="content" value=""></textarea>
                      </li>
                      <li>
                        <label class="control-label">Снимки</label>
                        <div class="drop-area" name="add">
                          <input type="file" name="images[]" class="drop-area-input" id="fileElem-add" accept="image/*">
                          <label class="button" for="fileElem-add">
                            Качи снимка
                          </label>
                          <div class="drop-area-gallery"></div>
                        </div>
                      </li>
                      <li class="clearfix"></li>
                      <li class="unpadding-top">
                        <button type="submit" class="btn">
                          Изпратете запитване
                        </button>
                        <input type="hidden" name="archive_date" value="{{$archive_date}}"/>
                        <input type="hidden" name="size" value="{{$size}}"/>
                        <input type="hidden" name="weight" value="{{$weight}}"/>
                        <input type="hidden" name="type" value="{{$type}}"/>
                        <input type="hidden" name="unique_number" value="{{$unique_number}}"/>
                      </li>
                      <li>
                        <small class="g-recaptcha-notice-text">
                          This site is protected by reCAPTCHA and the Google
                          <a href="https://policies.google.com/privacy">Privacy Policy</a> and
                          <a href="https://policies.google.com/terms">Terms of Service</a> apply.
                        </small>
                      </li>
                    </ul>
                  </form>
                </div>
                <div class="right-block contact-content col-md-12">
                  <h6 class="sb-title">
                    <i class="fa fa-home"></i>
                    Информация за контакти
                  </h6>
                  <ul class="right-content contact">
                    <li class="title">
                      <h6>Адрес на магазин</h6>
                    </li>
                    <li class="address">
                      <i class="fa fa-map-marker"></i>
                      гр.София, бул."Княгиня Мария-Луиза" 125
                    </li>
                    <li class="phone">
                      <i class="fa fa-phone"></i>
                      +359 888 770 160 - дизайнер
                    </li>
                    <li class="phone">
                      <i class="fa fa-phone"></i>
                      +359 887 957 766 - магазин
                    </li>
                    <li class="email">
                      <i class="fa fa-envelope"></i>
                      uvelgold@gmail.com
                    </li>
                    <li>
                      ------------------------------------
                    </li>
                    <li class="title">
                    <h6>
                      <i class="fa fa-cog  fa-1x"></i>  
                      Работно време на магазините
                    </h6>
                    </li>
                    <li>                      
                      Понеделник - петък: 9:30 - 18:30
                    </li>
                    <li>                      
                      Събота: 10:00 - 15:00
                    </li>
                    <li>                      
                      Неделя: почивен ден
                    </li>

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

<!-- Script for pre-filling the file input with the attachment -->
@if(isset($attachment))
  @php
    $descriptionContent = '';
    if (isset($archive_date)) {
      $descriptionContent .= 'Дата на архив: ' . Carbon\Carbon::parse($archive_date)->format('y m d') . '\n';
    }
    if (isset($size)) {
      $descriptionContent .= 'Размер: '. $size . '\n';
    }
    if (isset($weight)) {
      $descriptionContent .= 'Тегло: '. $weight . '\n';
    }
    if (isset($type)) {
      $descriptionContent .= 'Тип: '. $type . '\n';
    }
    if (isset($unique_number)) {
      $descriptionContent .= 'Уникален номер: '. $unique_number . '\n';
    }
  @endphp
  @push('scoped-scripts')
      <script>
          function generateBlob(url) {
              return fetch(url)
                  .then(response => response.blob())
                  .then(blob => {
                      const fileName = url.split('/').pop();
                      const mimeType = blob.type;
                      return new File([blob], fileName, { type: mimeType });
                  });
          }

          $(document).ready(function () {
              const attachmentUrl = "{{ $attachment }}";
              const mediaType     = "{{ $mediaType }}";
              const inputElement  = document.getElementById('fileElem-add');
              const gallery       = document.querySelector('.drop-area-gallery');
              const img           = document.createElement('img');
              const description   = $(".description");
              description.val("{{$descriptionContent}}").change();

              let thumbnailUrl;
              generateBlob(attachmentUrl).then(file => {
                  const dataTransfer = new DataTransfer();
                  dataTransfer.items.add(file);
                  inputElement.files = dataTransfer.files;
                  img.src = attachmentUrl;
                  img.alt = 'Снимка';
                  img.style.maxWidth = '180px';

                  const createImageWrapper = document.createElement('div');
                  createImageWrapper.classList.add('image-wrapper');
                  const createCloseBtn = document.createElement('div');
                  createCloseBtn.classList.add('close');
                  createCloseBtn.innerText = 'x'
                  createImageWrapper.appendChild(createCloseBtn);
                  createImageWrapper.appendChild(img);
                  $(createCloseBtn).on('click', e => {
                    $(e.currentTarget).parent('.image-wrapper').remove();
                  });

                  gallery.appendChild(createImageWrapper);
              }).catch(err => console.error("Error fetching the image:", err));
          });
      </script>
  @endpush
@endif
