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

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'store']], function() {
    Route::get('/', 'DashboardController@index')->name('admin');

    Route::get('/repairtypes', 'RepairTypeController@index')->name('repairtypes');
    Route::post('/repairtypes', 'RepairTypeController@store');
    Route::get('/repairtypes/{type}', 'RepairTypeController@edit');

    Route::get('/repairs', 'RepairController@index')->name('repairs');
    Route::post('/repairs', 'RepairController@store');
    Route::get('/repairs/{repair}', 'RepairController@edit');

    Route::get('/selling', 'SellingsController@index')->name('selling');
    Route::post('/selling', 'SellingsController@store');

    Route::get('/stones/sizes', 'StoneSizeController@index')->name('sizes');
    Route::post('/stones/sizes', 'StoneSizeController@store');

    Route::get('/stones/styles', 'StoneStyleController@index')->name('styles');
    Route::post('/stones/styles', 'StoneStyleController@store');

    Route::get('/stones/contours', 'StoneContourController@index')->name('contours');
    Route::post('/stones/contours', 'StoneContourController@store');

    //Route::get('/users/substitution/{user}', 'UsersubstitutionsController@show');

    Route::get('/users/substitutions', 'UsersubstitutionsController@index')->name('substitutions');
    Route::get('/users/substitutions/{substitution}', 'UsersubstitutionsController@edit');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{user}', 'UserController@edit');

    Route::get('/stones', 'StoneController@index')->name('stones');
    Route::post('/stones', 'StoneController@store');

    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::get('/stores', 'StoresController@index')->name('stores');
    Route::post('/stores', 'StoresController@store');

    Route::get('/stores/{store}', 'StoresController@edit');
    //Route::put('/stores/{store}', 'StoresController@update');

    Route::get('/nomenclatures', 'NomenclaturesController@index')->name('nomenclatures');
    Route::post('/nomenclatures', 'NomenclaturesController@store');

    Route::get('/materials', 'MaterialController@index')->name('materials');
    Route::post('/materials', 'MaterialController@store');

    Route::get('/materialstypes', 'MaterialTypeController@index')->name('materialstypes');
    Route::post('/materialstypes', 'MaterialTypeController@store');

    Route::get('/materialstypes/{material}', 'MaterialTypeController@edit');

    Route::get('/materials/{material}', 'MaterialController@edit');
    Route::put('/materials/{material}', 'MaterialController@update');

    Route::get('/materials/accept/{material}', 'MaterialTravellingController@accept');

    Route::get('/mquantity', 'MaterialQuantityController@index')->name('materials_quantity');
    Route::post('/mquantity', 'MaterialQuantityController@store');

    Route::get('/mtravelling', 'MaterialTravellingController@index')->name('materials_travelling');
    Route::post('/mtravelling', 'MaterialTravellingController@store');

    Route::get('/mquantity/{material}', 'MaterialQuantityController@edit');

    Route::get('/prices', 'PriceController@index')->name('prices');
    Route::post('/prices', 'PriceController@index');

    Route::get('/prices/{material}', 'PriceController@show')->name('view-price');
    Route::post('/prices/{material}', 'PriceController@store');

    Route::get('/prices/edit/{price}', 'PriceController@edit');

    Route::get('/jewels', 'JewelController@index')->name('jewels');
    Route::post('/jewels', 'JewelController@store');

    Route::get('/jewels/{jewel}', 'JewelController@edit');

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
    Route::post('/settings/currencies', 'CurrencyController@store');

    Route::get('/settings/currencies/{currency}', 'CurrencyController@edit');

    Route::get('/discounts', 'DiscountCodeController@index')->name('discounts');

    Route::get('/discounts/{discount}', 'DiscountCodeController@edit');

    Route::get('/setDiscount/{barcode}',  'SellingsController@setDiscount');

    Route::get('/sell/clearCart', 'SellingsController@clearCart')->name('clearCart');

    Route::get('/stones/sizes/{size}', 'StoneSizeController@edit');

    Route::get('/stones/styles/{style}', 'StoneStyleController@edit');

    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::get('/stones/contours/{contour}', 'StoneContourController@edit');

    Route::get('/repairs/certificate/{id}', 'RepairController@certificate');

    Route::get('/repairs/return/{repair}', 'RepairController@return');
    Route::get('/repairs/edit/{repair}', 'RepairController@edit');
});

Route::group(['prefix' => 'ajax'], function() {

    Route::post('/stores', 'StoresController@store');
    Route::put('/stores/{store}', 'StoresController@update');
    Route::get('/stores/{store}', 'StoresController@edit');
    Route::post('/stores/delete/{store}', 'StoresController@destroy');

    Route::post('/materials', 'MaterialController@store');
    Route::post('/materials/delete/{material}', 'MaterialController@destroy');

    Route::post('/materialstypes', 'MaterialTypeController@store');
    Route::post('/materialstypes/delete/{material}', 'MaterialTypeController@destroy');

    Route::post('/repairtypes', 'RepairTypeController@store');

    Route::post('/stones', 'StoneController@store');
    Route::post('/stones/delete/{stone}', 'StoneController@destroy');

    Route::post('/stones/sizes', 'StoneSizeController@store');
    Route::get('/stones/sizes/{size}', 'StoneSizeController@edit');

    Route::post('/stones/styles', 'StoneStyleController@store');
    Route::get('/stones/styles/{style}', 'StoneStyleController@edit');

    Route::put('/stones/{stone}', 'StoneController@update');
    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::post('/stones/contours', 'StoneContourController@store');
    Route::get('/stones/contours/{contour}', 'StoneContourController@edit');

    Route::post('/stones/sizes/delete/{size}', 'StoneSizeController@destroy');
    Route::post('/stones/styles/delete/{style}', 'StoneStyleController@destroy');
    Route::post('/stones/contours/delete/{contour}', 'StoneContourController@destroy');

    Route::put('/stones/sizes/{size}', 'StoneSizeController@update');
    Route::put('/stones/styles/{style}', 'StoneStyleController@update');
    Route::put('/stones/contours/{contour}', 'StoneContourController@update');

    Route::post('/prices/{material}', 'PriceController@store');
    Route::post('/prices/delete/{price}', 'PriceController@destroy');
    Route::put('/prices/{price}', 'PriceController@update');

    Route::post('/jewels', 'JewelController@store');
    Route::put('/jewels/{jewel}', 'JewelController@update');
    Route::post('/jewels/delete/{jewel}', 'JewelController@destroy');

    Route::post('/models', 'ModelsController@store');
    Route::put('/models/{model}', 'ModelsController@update');
    Route::post('/models/delete/{model}', 'ModelsController@destroy');

    Route::post('/mquantity', 'MaterialQuantityController@store');
    Route::post('/mquantity/delete/{material}', 'MaterialQuantityController@destroy');

    Route::post('/mquantity/deletebymaterial/{material}', 'MaterialQuantityController@deleteByMaterial');

    Route::post('/sendMaterial', 'MaterialTravellingController@store');

    Route::put('/mquantity/{material}', 'MaterialQuantityController@update');
    
    Route::put('/materials/{material}', 'MaterialController@update');

    Route::put('/materialstypes/{material}', 'MaterialTypeController@update');

    Route::put('/users/{user}', 'UserController@update');

    Route::post('/users', 'UserController@store');
    Route::post('/users/delete/{user}', 'UserController@destroy');

    //Route::put('/users/substitutions/{user}', 'UsersubstitutionsController@store');

    Route::post('/repairs', 'RepairController@store');

    Route::get('/repairs/return/{repair}', 'RepairController@return');
    Route::put('/repairs/return/{repair}', 'RepairController@returnRepair');

    Route::get('/repairs/edit/{repair}', 'RepairController@edit');
    Route::put('/repairs/edit/{repair}', 'RepairController@update');

    Route::get('/repairs/{barcode}', 'RepairController@scan');
    Route::get('/repairs/certificate/{id}', 'RepairController@certificate');
    Route::post('/repairs/delete/{repair}', 'RepairController@destroy');

    Route::put('/repairtypes/{type}', 'RepairTypeController@update');
    Route::post('/repairtypes/delete/{type}', 'RepairTypeController@destroy');

    Route::put('/repairs/{repair}', 'RepairController@update');

    Route::post('/discounts', 'DiscountCodeController@store');
    Route::put('/discounts/{discount}', 'DiscountCodeController@update');

    Route::get('/products/{model}', 'ProductsController@chainedSelects');

    Route::post('/products', 'ProductsController@store');
    Route::post('/products/delete/{product}', 'ProductsController@destroy');
    Route::put('/products/{id}', 'ProductsController@update');

    Route::post('/productsotherstypes', 'ProductsOthersTypesController@store');
    Route::put('/productsotherstypes/{type}', 'ProductsOthersTypesController@update');
    Route::post('/productsotherstypes/delete/{type}', 'ProductsOthersTypesController@destroy');

    Route::post('/productsothers', 'ProductsOthersController@store');
    Route::put('/productsothers/{product}', 'ProductsOthersController@update');
    Route::post('/productsothers/delete/{product}', 'ProductsOthersController@destroy');

    Route::get('discounts/check/{barcode}', 'DiscountCodeController@check');
    Route::post('discounts/delete/{discount}', 'DiscountCodeController@destroy');

    Route::post('/sell', 'SellingsController@sell')->name('sellScan');
    Route::get('/sell/setDiscount/{barcode}',  'SellingsController@setDiscount')->name('addDiscount');
    Route::get('/sellings/information', 'SellingsController@printInfo');

    Route::post('/sell/removeItem/{item}', 'SellingsController@removeItem');

    Route::post('/sell/payment', 'PaymentController@store');

    Route::post('/settings/currencies', 'CurrencyController@store');
    Route::post('/settings/currencies/delete/{currency}', 'CurrencyController@destroy');
    Route::put('/settings/currencies/{currency}', 'CurrencyController@update');

    Route::get('/getPrices/{material}', 'PriceController@getByMaterial');

    Route::post('/users/substitutions', 'UsersubstitutionsController@store');

    Route::put('/users/substitutions/{substitution}', 'UsersubstitutionsController@update');
    Route::post('/users/substitutions/delete/{substitution}', 'UsersubstitutionsController@destroy');

    Route::post('/gallery/delete/{photo}', 'GalleryController@destroy');
});