<?php
use Illuminate\Support\Facades\Session;

// Home
Breadcrumbs::register('store', function ($breadcrumbs) {
    $breadcrumbs->push('Начало', route('store'));
});

// Home > About
Breadcrumbs::register('web_blog', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Блог', route('translated_articles', [app()->getLocale()]));
});

Breadcrumbs::register('single_translated_article', function ($breadcrumbs, $article) {
    $breadcrumbs->parent('web_blog');
    $breadcrumbs->push($article->title, route('single_translated_article', ['locale' => app()->getLocale(), 'article' => $article->id]));
});

Breadcrumbs::register('contactus', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Контакти', route('contactus'));
});

Breadcrumbs::register('privacy_policy', function($breadcrumbs){
    $breadcrumbs->parent('store');
    $breadcrumbs->push(App\CMS::get('privacy_policy', true), route('privacy_policy'));
});

Breadcrumbs::register('cookies_policy', function($breadcrumbs){
    $breadcrumbs->parent('store');
    $breadcrumbs->push(App\CMS::get('cookies_policy', true), route('cookies_policy'));
});

Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Количка', route('cart'));
});

Breadcrumbs::register('register', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Регистрация', route('register'));
});

Breadcrumbs::register('stores', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Магазини', route('stores'));
});

Breadcrumbs::register('settings', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Настройки', route('user_settings'));
});

Breadcrumbs::register('prices', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Цени', route('storePrices'));
});

Breadcrumbs::register('warranty', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Гаранция', route('warranty'));
});

Breadcrumbs::register('about_us', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push(App\CMS::get('about_us', true), route('about'));
});

Breadcrumbs::register('howtoorder', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Как да поръчате', route('howtoorder'));
});

// Breadcrumbs::register('user_model_orders', function ($breadcrumbs) {
//     $breadcrumbs->parent('store');
//     $breadcrumbs->push('Поръчки', route('user_model_orders'));
// });

Breadcrumbs::register('login', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Вход в системата', route('login'));
});

Breadcrumbs::register('custom_order', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Поръчка по ваш модел', route('custom_order'));
});

Breadcrumbs::register('model_orders', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Модели по поръчка', route('model_orders'));
});

Breadcrumbs::register('models', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Модели по поръчка',
        urldecode(Session::get('models_active_filters')) ?: route('model_orders')
    );
});

Breadcrumbs::register('products', function ($breadcrumbs) {
	$breadcrumbs->parent('store');
    $breadcrumbs->push('Налични бижута', route('products'));
});

Breadcrumbs::register('products_active_filters', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Налични бижута',
        urldecode(Session::get('products_active_filters')) ?: route('products')
    );
});

Breadcrumbs::register('productsothers', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Налични продукти', route('productsothers'));
});

Breadcrumbs::register('wishlist', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Желани продукти', route('wishlist'));
});

Breadcrumbs::register('single_product', function ($breadcrumbs, $product) {
    // $breadcrumbs->parent('products_active_filters');
    // $breadcrumbs->push($product->id, route('single_product', $product->id));
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Налични бижута', route('products'));
});

Breadcrumbs::register('single_product_other', function ($breadcrumbs, $product) {
    // $breadcrumbs->parent('productsothers');
    // $breadcrumbs->push($product->name, route('single_product_other', $product->id));
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Налични бижута', route('products'));
});

Breadcrumbs::register('single_model', function ($breadcrumbs, $model) {
    // $breadcrumbs->parent('models');
    // $breadcrumbs->push($model->name, route('single_model', $model->id));
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Модели по поръчка', route('products'));
});

Breadcrumbs::register('user_account', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Профил', route('user_account'));
});
