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
    Route::get('/', 'Dashboardcontroller@index');

    Route::get('/stones/sizes', 'StoneSizesController@index');
    Route::post('/stones/sizes', 'StoneSizesController@store');

    Route::get('/stones/styles', 'StoneStylesController@index');
    Route::post('/stones/styles', 'StoneStylesController@store');

    Route::get('/stones/contours', 'StoneContoursController@index');
    Route::post('/stones/contours', 'StoneContoursController@store');

    Route::get('/stones', 'StonesController@index');
    Route::post('/stones', 'StonesController@store');

    Route::get('/stores', 'StoresController@index');
    Route::post('/stores', 'StoresController@store');

    Route::get('/stores/{store}', 'StoresController@edit');
    Route::post('/stores/{store}', 'StoresController@update');

    Route::get('/nomenclatures', 'NomenclaturesController@index');
    Route::post('/nomenclatures', 'NomenclaturesController@store');

    Route::get('/materials', 'MaterialsController@index');
    Route::post('/materials', 'MaterialsController@store');

    Route::get('/materials/{material}', 'MaterialsController@edit');
    Route::post('/materials/{material}', 'MaterialsController@update');

    Route::get('/prices', 'PricesController@index');
    Route::post('/prices', 'PricesController@index');

    Route::get('/prices/{material}', 'PricesController@show');
    Route::post('/prices/{material}', 'PricesController@store')->name('prices');

    Route::get('/jewels', 'JewelsController@index');
    Route::post('/jewels', 'JewelsController@store');

    Route::get('/jewels/{jewel}', 'JewelsController@edit');
    Route::post('/jewels/{jewel}', 'JewelsController@update');

    Route::get('/models', 'ModelsController@index');
    Route::post('/models', 'ModelsController@store');

    Route::get('/models/{model}', 'ModelsController@edit');
    Route::post('/models/{model}', 'ModelsController@update');

    Route::get('/products', 'ProductsController@index');
    Route::post('/products', 'ProductsController@store');

    
});