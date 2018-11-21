<?php

// Home
Breadcrumbs::register('store', function ($breadcrumbs) {
    $breadcrumbs->push('Начало', route('store'));
});

// Home > About
Breadcrumbs::register('web_blog', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Блог', route('blog'));
});

Breadcrumbs::register('contactus', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Контакти', route('contactus'));
});

Breadcrumbs::register('cart', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Количка', route('cart'));
});

Breadcrumbs::register('register', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Регистрация', route('register'));
});

Breadcrumbs::register('settings', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Настройки', route('settings'));
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
    $breadcrumbs->push('Поръчка по модел на клиента', route('custom_order'));
});

Breadcrumbs::register('model_orders', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Поръчка по модел', route('model_orders'));
});

Breadcrumbs::register('models', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Каталог с модели', route('models'));
});

Breadcrumbs::register('products', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Каталог с продукти', route('products'));
});

Breadcrumbs::register('productsothers', function ($breadcrumbs) {
    $breadcrumbs->parent('store');
    $breadcrumbs->push('Каталог с продукти', route('productsothers'));
});

Breadcrumbs::register('single_product', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('products');
    $breadcrumbs->push($product->name, route('single_product', $product->id));
});

Breadcrumbs::register('single_product_other', function ($breadcrumbs, $product) {
    $breadcrumbs->parent('productsothers');
    $breadcrumbs->push($product->name, route('single_product_other', $product->id));
});

Breadcrumbs::register('single_model', function ($breadcrumbs, $model) {
    $breadcrumbs->parent('models');
    $breadcrumbs->push($model->name, route('single_model', $model->id));
});

// // Home > Blog
// Breadcrumbs::register('blog', function ($breadcrumbs) {
//     $breadcrumbs->parent('home');
//     $breadcrumbs->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::register('category', function ($breadcrumbs, $category) {
//     $breadcrumbs->parent('blog');
//     $breadcrumbs->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Post]
// Breadcrumbs::register('post', function ($breadcrumbs, $post) {
//     $breadcrumbs->parent('category', $post->category);
//     $breadcrumbs->push($post->title, route('post', $post));
// });