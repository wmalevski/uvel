<?php
/*
 * Secret key and Site key get on https://www.google.com/recaptcha
 * */
return [
    'secret' => env('INVISIBLE_RECAPTCHA_SECRETKEY', 'default_secret'),
    'sitekey' => env('INVISIBLE_RECAPTCHA_SITEKEY', 'default_sitekey'),
    /**
     * @var string|null Default ``null``.
     * Custom with function name (example customRequestCaptcha) or class@method (example \App\CustomRequestCaptcha@custom).
     * Function must be return instance, read more in folder ``examples``
     */
    'request_method' => null,
    'options' => [
        'multiple' => false,
        'lang' => app()->getLocale(),
    ],
    'attributes' => [
        'theme' => 'light'
    ],
];