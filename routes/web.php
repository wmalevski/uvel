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

Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function() {
    Route::get('/', 'DashboardController@index')->name('admin');

    Route::get('/repairtypes', 'RepairTypesController@index')->name('repairtypes');
    Route::post('/repairtypes', 'RepairTypesController@store');
    Route::get('/repairtypes/{type}', 'RepairTypesController@edit');

    Route::get('/repairs', 'RepairsController@index')->name('repairs');
    Route::post('/repairs', 'RepairsController@store');
    Route::get('/repairs/{repair}', 'RepairsController@edit');

    Route::get('/selling', 'SellingsController@index')->name('selling');
    Route::post('/selling', 'SellingsController@store');

    Route::get('/stones/sizes', 'StoneSizesController@index')->name('sizes');
    Route::post('/stones/sizes', 'StoneSizesController@store');

    Route::get('/stones/styles', 'StoneStylesController@index')->name('styles');
    Route::post('/stones/styles', 'StoneStylesController@store');

    Route::get('/stones/contours', 'StoneContoursController@index')->name('contours');
    Route::post('/stones/contours', 'StoneContoursController@store');

    Route::get('/users/substitution/{user}', 'UsersubstitutionsController@show');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{user}', 'UserController@edit');

    Route::get('/stones', 'StonesController@index')->name('stones');
    Route::post('/stones', 'StonesController@store');

    Route::get('/stones/{stone}', 'StonesController@edit');

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

    Route::get('/materials/accept/{material}', 'MaterialsTravellingController@accept');

    Route::get('/mquantity', 'MaterialsQuantityController@index')->name('materials_quantity');
    Route::post('/mquantity', 'MaterialsQuantityController@store');

    Route::get('/mtravelling', 'MaterialsTravellingController@index')->name('materials_travelling');
    Route::post('/mtravelling', 'MaterialsTravellingController@store');

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

    Route::get('/products/{id}', 'ProductsController@edit');
    Route::get('/products', 'ProductsController@index')->name('products');
    Route::post('/products', 'ProductsController@store');

    Route::get('/productsothers', 'ProductsOthersController@index')->name('productsothers');
    Route::get('/productsothers/{product}', 'ProductsOthersController@edit');
    //Route::put('/productsothers/{product}', 'ProductsOthersController@update');

    Route::get('/productsotherstypes', 'ProductsOthersTypesController@index')->name('productsotherstypes');
    Route::get('/productsotherstypes/{type}', 'ProductsOthersTypesController@edit');

    Route::get('/settings', 'SettingsController@index')->name('settings');
    Route::post('/settings', 'SettingsController@store');

    Route::get('/settings/stock', 'SettingsController@stockPrices')->name('stockPrices');
    Route::post('/settings/stock', 'SettingsController@updatePrices');

    Route::get('/settings/currencies', 'SettingsController@currencies')->name('currencies');
    Route::post('/settings/currencies', 'CurrenciesController@store');

    Route::get('/discounts', 'DiscountCodesController@index')->name('discounts');

    Route::get('/discounts/{discount}', 'DiscountCodesController@edit');

    Route::get('/setDiscount/{barcode}',  'SellingsController@setDiscount');

    Route::get('/sell/clearCart', 'SellingsController@clearCart')->name('clearCart');
});

Route::group(['prefix' => 'ajax'], function() {

    Route::post('/stores', 'StoresController@store');
    Route::put('/stores/{store}', 'StoresController@update');
    Route::get('/stores/{store}', 'StoresController@edit');

    Route::post('/materials', 'MaterialsController@store');

    Route::post('/repairtypes', 'RepairTypesController@store');

    Route::post('/stones', 'StonesController@store');
    Route::post('/stones/sizes', 'StoneSizesController@store');
    Route::post('/stones/styles', 'StoneStylesController@store');
    Route::put('/stones/{stone}', 'StonesController@update');
    Route::get('/stones/{stone}', 'StonesController@edit');
    Route::post('/stones/contours', 'StoneContoursController@store');

    Route::post('/stones/sizes/delete/{size}', 'StoneSizesController@destroy');
    Route::post('/stones/styles/delete/{style}', 'StoneStylesController@destroy');
    Route::post('/stones/contours/delete/{contour}', 'StoneContoursController@destroy');

    Route::post('/prices/{material}', 'PricesController@store');

    Route::post('/jewels', 'JewelsController@store');
    Route::put('/jewels/{jewel}', 'JewelsController@update');

    Route::post('/models', 'ModelsController@store');
    Route::put('/models/{model}', 'ModelsController@update');

    Route::post('/mquantity', 'MaterialsQuantityController@store');

    Route::post('/sendMaterial', 'MaterialsTravellingController@store');

    Route::put('/mquantity/{material}', 'MaterialsQuantityController@update');
    
    Route::put('/materials/{material}', 'MaterialsController@update');

    Route::put('/users/{user}', 'UserController@update');

    Route::post('/users', 'UserController@store');

    Route::put('/users/substitutions/{user}', 'UsersubstitutionsController@store');

    Route::post('/repairs', 'RepairsController@store');

    Route::get('/repairs/return/{repair}', 'RepairsController@return');
    Route::post('/repairs/return/{repair}', 'RepairsController@returnRepair');

    Route::get('/repairs/{barcode}', 'RepairsController@scan');
    Route::get('/repairs/certificate/{id}', 'RepairsController@certificate');
    Route::post('/repairs/delete/{repair}', 'RepairsController@destroy');

    Route::put('/repairtypes/{type}', 'RepairTypesController@update');
    Route::post('/repairtypes/delete/{type}', 'RepairTypesController@destroy');

    Route::put('/repairs/{repair}', 'RepairsController@update');

    Route::post('/discounts', 'DiscountCodesController@store');
    Route::put('/discounts/{discount}', 'DiscountCodesController@update');

    Route::get('/products/{model}', 'ProductsController@chainedSelects');

    Route::post('/products', 'ProductsController@store');

    Route::post('/productsotherstypes', 'ProductsOthersTypesController@store');
    Route::put('/productsotherstypes/{type}', 'ProductsOthersTypesController@update');
    Route::post('/productsotherstypes/delete/{type}', 'ProductsOthersTypesController@destroy');

    Route::post('/productsothers', 'ProductsOthersController@store');
    Route::put('/productsothers/{product}', 'ProductsOthersController@update');

    Route::get('discounts/check/{barcode}', 'DiscountCodesController@check');
    Route::post('discounts/delete/{discount}', 'DiscountCodesController@destroy');

    Route::post('/sell', 'SellingsController@sell')->name('sellScan');
    Route::get('/sell/setDiscount/{barcode}',  'SellingsController@setDiscount')->name('addDiscount');

    Route::post('/sell/removeItem/{item}', 'SellingsController@removeItem');

    Route::post('/settings/currencies', 'CurrenciesController@store');

    Route::get('/getPrices/{material}', 'PricesController@getByMaterial');
});