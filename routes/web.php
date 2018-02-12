<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['role:superadministrator|administrator']], function() {
    Route::get('/', 'DashboardController@index')->name('admin');

    Route::get('/stones/sizes', 'StoneSizesController@index')->name('sizes');
    Route::post('/stones/sizes', 'StoneSizesController@store');

    Route::get('/stones/styles', 'StoneStylesController@index')->name('styles');
    Route::post('/stones/styles', 'StoneStylesController@store');

    Route::get('/stones/contours', 'StoneContoursController@index')->name('contours');
    Route::post('/stones/contours', 'StoneContoursController@store');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{user}', 'UserController@edit');

    Route::get('/stones', 'StonesController@index')->name('stones');
    Route::post('/stones', 'StonesController@store');

    Route::get('/stores', 'StoresController@index')->name('stores');
    Route::post('/stores', 'StoresController@store');

    Route::get('/stores/{store}', 'StoresController@edit');
    //Route::put('/stores/{store}', 'StoresController@update');

    Route::get('/nomenclatures', 'NomenclaturesController@index')->name('nomenclatures');
    Route::post('/nomenclatures', 'NomenclaturesController@store');

    Route::get('/materials', 'MaterialsController@index')->name('materials');
    Route::post('/materials', 'MaterialsController@store');

    Route::get('/materials/{material}', 'MaterialsController@edit');
    Route::put('/materials/{material}', 'MaterialsController@update');

    Route::get('/mquantity', 'MaterialsQuantityController@index')->name('materials_quantity');
    Route::post('/mquantity', 'MaterialsQuantityController@store');

    Route::get('/mquantity/{material}', 'MaterialsQuantityController@edit');

    Route::get('/prices', 'PricesController@index')->name('prices');
    Route::post('/prices', 'PricesController@index');

    Route::get('/prices/{material}', 'PricesController@show')->name('view-price');
    Route::post('/prices/{material}', 'PricesController@store');

    Route::get('/jewels', 'JewelsController@index')->name('jewels');
    Route::post('/jewels', 'JewelsController@store');

    Route::get('/jewels/{jewel}', 'JewelsController@edit');

    Route::get('/models', 'ModelsController@index')->name('models');
    Route::post('/models', 'ModelsController@store');

    Route::get('/models/{model}', 'ModelsController@edit');
    Route::put('/models/{model}', 'ModelsController@update');

    Route::get('/products', 'ProductsController@index')->name('products');
    Route::post('/products', 'ProductsController@store');

    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@store');
    Route::post('/settings/updatePrices', 'SettingsController@updatePrices');
});

Route::group(['prefix' => 'ajax', 'middleware' => ['role:superadministrator|administrator']], function() {
    Route::post('/stores', 'StoresController@store');
    Route::post('/materials', 'MaterialsController@store');
    Route::post('/stones', 'StonesController@store');
    Route::post('/stones/sizes', 'StoneSizesController@store');
    Route::post('/stones/styles', 'StoneStylesController@store');
    Route::post('/stones/contours', 'StoneContoursController@store');
    Route::post('/prices/{material}', 'PricesController@store');
    Route::post('/jewels', 'JewelsController@store');
    Route::put('/jewels/{jewel}', 'JewelsController@update');
    Route::post('/models', 'ModelsController@store');
    Route::put('/stores/{store}', 'StoresController@update');
    Route::get('/stores/{store}', 'StoresController@edit');
    Route::post('/mquantity', 'MaterialsQuantityController@store');
    Route::post('/sendMaterial', 'MaterialsTravellingController@store');
    Route::put('/mquantity/{material}', 'MaterialsQuantityController@update');
    Route::put('/materials/{material}', 'MaterialsController@update');
    Route::put('/models/{model}', 'ModelsController@update');
    Route::put('/users/{user}', 'UserController@update');
});