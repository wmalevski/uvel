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

Route::get('/', 'Store\StoreController@index')->name('store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'store']], function () {
    //Active urls for roles: CASHIER, MANAGER and ADMIN.
    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_CASHIER]], function () {
        //Selling section
        Route::get('/', 'SellingController@index')->name('admin');
        Route::get('/selling', 'SellingController@index')->name('selling');
        Route::post('/selling', 'SellingController@store');
        Route::get('/selling/online', 'OnlineSellingsController@index')->name('online_selling');
        Route::get('/selling/online/{selling}', 'OnlineSellingsController@edit');
        Route::put('/selling/online/{selling}', 'OnlineSellingsController@update');
        Route::get('/setDiscount/{barcode}', 'SellingController@setDiscount');
        Route::get('/cartMaterialsInfo', 'SellingController@cartMaterialsInfo')->name('cart_materials');
        Route::get('/sell/clearCart', 'SellingController@clearCart')->name('clear_cart');

        //Orders section
        Route::get('/orders/custom', 'CustomOrderController@index')->name('custom_orders');

        //Product travelling
        Route::get('/productstravelling', 'ProductTravellingController@index')->name('products_travelling');
        Route::post('/productstravelling', 'ProductTravellingController@store');
        Route::get('productstravelling/addByScan/{product}', 'ProductTravellingController@addByScan');


        //Things Vizo moved to be at least protected somehow..
        Route::get('/models/view/{model}', 'ModelController@getModelInformation');
        Route::get('/products/view/{product}', 'ProductController@getProductInformation');
        Route::get('/models/calculateStonesTotalWeight/{stone}/{stonesTotal}', 'ModelController@calculateStonesTotalWeight');

        Route::get('/infoemails', 'InfoMailController@index')->name('info_emails');
        Route::get('/infoemails/{email}', 'InfoMailController@edit');

        Route::get('/infophones', 'InfoPhoneController@index')->name('info_phones');
        Route::get('/infophones/{phone}', 'InfoPhoneController@edit');

        Route::get('/sell/partner', 'PaymentController@partner_payment');

        Route::get('/repairs', 'RepairController@index')->name('repairs');
        Route::post('/repairs', 'RepairController@store');

        Route::get('/orders', 'OrderController@index')->name('orders');

        Route::get('/users', 'UserController@index')->name('users');

        Route::get('/partners', 'PartnerController@index')->name('partners');

        Route::get('/partnermaterials/{partner}', 'PartnerMaterialController@index')->name('partner_materials');

        Route::get('/stores', 'StoreController@index')->name('stores');
        Route::post('/stores', 'StoreController@store');

        Route::get('/payments', 'PaymentController@index')->name('payments');

        Route::get('/stores/{store}', 'StoreController@edit');

        Route::get('/nomenclatures', 'NomenclatureController@index')->name('nomenclatures');

        Route::get('/nomenclatures/{nomenclature}', 'NomenclatureController@edit');

        Route::get('/materials', 'MaterialController@index')->name('materials');
        Route::post('/materials', 'MaterialController@store');

        Route::get('/materials/{material}', 'MaterialController@edit');
        Route::put('/materials/{material}', 'MaterialController@update');

        Route::post('/materials/accept/{material}', 'MaterialTravellingController@accept');
        Route::post('/materials/decline/{material}', 'MaterialTravellingController@decline');

        Route::get('/mtravelling', 'MaterialTravellingController@index')->name('materials_travelling');
        Route::post('/mtravelling', 'MaterialTravellingController@store');

        Route::get('/orders/model', 'ModelOrderController@index')->name('model_orders_web');

        Route::get('/orders/model/{order}', 'ModelOrderController@edit');

        Route::get('/products', 'ProductController@index')->name('admin_products');
        Route::post('/products', 'ProductController@store');

        Route::get('/productsothers', 'ProductOtherController@index')->name('products_others');
        Route::get('/productsothers/{productOther}', 'ProductOtherController@edit');

        Route::get('/repairs/return/{repair}', 'RepairController@return');
        Route::get('/repairs/edit/{repair}', 'RepairController@edit');

        Route::get('/mailchimp', 'NewsletterController@index')->name('mailchimp');

        Route::post('/logout', 'UserController@logout')->name('admin_logout');

        Route::get('/orders/{order}', 'OrderController@edit');

        //Expenses
        Route::get('/expenses', 'ExpenseController@index')->name('expenses');
        Route::get('/expenses/{expense}', 'ExpenseController@edit');

        Route::get('/materialsreports', 'MaterialQuantityController@materialReport')->name('materials_reports');

        Route::get('/productsreports', 'ProductController@productsReport')->name('products_reports');

        Route::get('/safe', 'SafeController@index');
        //Models section
        Route::get('/models', 'ModelController@index')->name('admin_models');
        Route::post('/models', 'ModelController@store');

        //Materials section
        Route::get('/mquantity', 'MaterialQuantityController@index')->name('materials_quantity');

        //Stones section
        Route::get('/stones', 'StoneController@index')->name('stones');
        Route::post('/stones', 'StoneController@store');
    });

    //Active urls for roles: MANAGER and ADMIN.
    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_MANAGER]], function () {
        //Dailyreports section
        Route::get('/dailyreports', 'DailyReportController@index')->name('daily_reports');
        Route::get('/dailyreports/create', 'DailyReportController@create')->name('create_report');
        Route::post('/dailyreports/create/moneyreport', 'DailyReportController@moneyreport');
        Route::post('/dailyreports/create/jewelreport', 'DailyReportController@jewelreport');
        Route::post('/dailyreports/create/materialreport', 'DailyReportController@materialreport');
        Route::get('/dailyreports/{report}', 'DailyReportController@edit');

        //Discounts section
        Route::get('/discounts', 'DiscountCodeController@index')->name('discounts');
        Route::get('/discounts/{discountCode}', 'DiscountCodeController@edit');

        //Substitutions section
        Route::get('/users/substitutions', 'UserSubstitutionController@index')->name('substitutions');

        //Users in store
        Route::get('/stores/info/{store}', 'StoreController@show');

        //Reviews section
        Route::get('/reviews', 'ReviewController@index')->name('reviews');
        Route::get('/reviews/{review}', 'ReviewController@show')->name('show_review');
        Route::get('/reviews/product/{product}', 'ReviewController@index')->name('show_product_reviews');

        Route::get('/products/reviews/all', 'ProductController@showReviews')->name('products_reviews');
        Route::get('/productsothers/reviews/all', 'ProductOtherController@showReviews')->name('show_products_others_reviews');
        Route::get('/models/reviews/all', 'ModelController@showReviews')->name('show_model_reviews');

        //Selling section
        Route::get('/sellingreportsexport', 'SellingReportController@index')->name('selling_report_export');
        Route::get('/sellingreportsexport/{store}', 'SellingReportController@edit');
    });

    //Active urls for roles: STOREHOUSE and ADMIN.
    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_STOREHOUSE]], function () {
        // Route::get('/', 'StoreController@index')->name('stores');
        //Stones section
        Route::get('/stones/sizes', 'StoneSizeController@index')->name('sizes');
        Route::post('/stones/sizes', 'StoneSizeController@store');

        Route::get('/stones/styles', 'StoneStyleController@index')->name('styles');
        Route::post('/stones/styles', 'StoneStyleController@store');

        Route::get('/stones/contours', 'StoneContourController@index')->name('contours');
        Route::post('/stones/contours', 'StoneContourController@store');

        //Jewels section
        Route::get('/jewels', 'JewelController@index')->name('jewels');
        Route::post('/jewels', 'JewelController@store');

        //Expenses
        Route::get('/expensetypes', 'ExpenseTypeController@index')->name('expenses_types');
        Route::get('/expensetypes/edit/{type}', 'ExpenseTypeController@edit');

        //Productsothers
        Route::get('/productsotherstypes', 'ProductOtherTypeController@index')->name('products_others_types');
        Route::get('/productsotherstypes/{productOtherType}', 'ProductOtherTypeController@edit');

        //Materials type
        Route::get('/materialstypes', 'MaterialTypeController@index')->name('materials_types');
        Route::post('/materialstypes', 'MaterialTypeController@store');
        Route::get('/materialstypes/{materialType}', 'MaterialTypeController@edit');
    });

    //Active urls for ADMIN role.
    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_ADMIN]], function () {
        //Blog section
        Route::get('/blog', 'BlogController@index')->name('admin_blog');
        Route::get('/blog/{article}', 'BlogController@edit');
        Route::get('/blog/{article}/comments', 'BlogController@showComments');
        Route::post('/blog', 'BlogController@store');

        //Slides section
        Route::get('/slides', 'SliderController@index')->name('slides');
        Route::post('/slides', 'SliderController@store');
        Route::get('/slides/{slider}', 'SliderController@edit');
        Route::put('/slides/{slider}', 'SliderController@update');

        //Partners
        Route::get('/partners/{partner}', 'PartnerController@edit');
        Route::get('/partnermaterials/{partner}/{material}', 'PartnerMaterialController@edit');

        //Substitutions
        Route::get('/users/substitutions/{userSubstitution}', 'UserSubstitutionController@edit');

        //Products section
        Route::get('/products/{product}', 'ProductController@edit');

       //Users section
        Route::get('/users/{user}', 'UserController@edit');

        //Stones section
        Route::get('/stones/{stone}', 'StoneController@edit');
        Route::get('/stones/sizes/{stoneSize}', 'StoneSizeController@edit');
        Route::get('/stones/styles/{stoneStyle}', 'StoneStyleController@edit');
        Route::get('/stones/{stone}', 'StoneController@edit');
        Route::get('/stones/contours/{stoneContour}', 'StoneContourController@edit');

        //Repairs section
        Route::get('/repairs/{barcode}', 'RepairController@edit');
        Route::get('/repairtypes', 'RepairTypeController@index')->name('repair_types');
        Route::post('/repairtypes', 'RepairTypeController@store');
        Route::get('/repairtypes/{repairType}', 'RepairTypeController@edit');

        //Reviews section
        Route::post('/reviews/delete/{review}', 'ReviewController@destroy')->name('destroy_review');

        //Materials section
        Route::post('/mquantity', 'MaterialQuantityController@store');
        Route::get('/mquantity/{materialQuantity}', 'MaterialQuantityController@edit');

        //Jewels section
        Route::get('/jewels/{jewel}', 'JewelController@edit');

        //Stock
        Route::get('/settings/stock', 'SettingController@stockPrices')->name('stock_prices');
        Route::post('/settings/stock', 'SettingController@updatePrices');

        //Currencies
        Route::get('/settings/currencies', 'SettingController@currencies')->name('currencies');
        Route::post('/settings/currencies', 'CurrencyController@store');
        Route::get('/settings/currencies/{currency}', 'CurrencyController@edit');

        //Cashgroups
        Route::get('/settings/cashgroups', 'CashGroupController@index')->name('cashgroups');
        Route::get('/settings/cashgroups/{cashGroup}', 'CashGroupController@edit');

        // System Settings
        Route::get('/settings/system', 'SettingController@SystemSettings')->name('system_settings');
        Route::get('/system_settings/edit/{setting_type}', 'SettingController@EditSetting');
        Route::put('/system_settings/update/{key}', 'SettingController@UpdateSetting');

        //Orders section
        Route::get('/orders/custom/{order}', 'CustomOrderController@edit');

        //Price section
        Route::get('/prices', 'PriceController@index')->name('prices');
        Route::post('/prices', 'PriceController@index');

        Route::get('/prices/{material}', 'PriceController@show')->name('view_price');
        Route::post('/prices/{material}', 'PriceController@store');

        Route::get('/prices/edit/{price}', 'PriceController@edit');

        //Reports
        Route::get('/mtravellingreports', 'MaterialTravellingController@mtravellingReport')->name('mtravelling_reports');
        Route::get('/productstravellingreports', 'ProductTravellingController@productstravellingReport')->name('productstravelling_reports');

        // Cash register
        Route::get('/cash_register', 'CashRegisterController@index')->name('cash_register');

        //Models section
        Route::get('/models/{model}', 'ModelController@edit');
        Route::put('/models/{model}', 'ModelController@update');
    });

});

Route::group(['prefix' => 'ajax'], function() {
    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_CASHIER]], function () {
        //Print
        Route::get('/selling/certificate/{id}/{orderId?}', 'SellingController@certificate')->name('selling_certificate');
        Route::get('/selling/receipt/{id}/{type}/{orderId?}', 'SellingController@receipt')->name('selling_receipt');
        Route::get('/generate/exchangeacquittance/{id}', 'PaymentController@generateExchangeAcquittance');

        //Selling section
        Route::post('/sell', 'SellingController@sell')->name('sellScan');
        Route::get('/setDiscount/{barcode}',  'SellingController@setDiscount')->name('add_discount');
        Route::get('/removeDiscount/{name}',  'SellingController@removeDiscount')->name('remove_discount');
        Route::post('/sendDiscount',  'SellingController@sendDiscount')->name('send_discount');
        Route::get('/sellings/information', 'SellingController@printInfo');
        Route::post('/sell/removeItem/{type}/{item}', 'SellingController@removeItem');

        //Orders
        Route::put('/orders/custom/{order}', 'CustomOrderController@update');
        Route::put('/orders/model/{order}', 'ModelOrderController@update');

        //Product travelling
        Route::get('productstravelling/addByScan/{product}', 'ProductTravellingController@addByScan');
        Route::get('/productstravelling/accept/{product}', 'ProductTravellingController@accept');
        Route::post('/productstravelling', 'ProductTravellingController@store');
    });

    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_MANAGER]], function () {
        //Substitutions section
        Route::post('/users/substitutions', 'UserSubstitutionController@store');

        //Discounts section
        Route::get('/discounts/print/{id}', 'DiscountCodeController@generate');
        Route::post('/discounts', 'DiscountCodeController@store');
        Route::put('/discounts/{discountCode}', 'DiscountCodeController@update');
        Route::get('discounts/check/{barcode}', 'DiscountCodeController@check');

        //Materials section
        Route::post('/mquantity', 'MaterialQuantityController@store');
        Route::post('/mquantity/delete/{materialQuantity}', 'MaterialQuantityController@destroy');
        Route::post('/mquantity/deletebymaterial/{material}', 'MaterialQuantityController@deleteByMaterial');
        Route::put('/mquantity/{materialQuantity}', 'MaterialQuantityController@update');
    });

    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_STOREHOUSE]], function () {
        //Stones section
        Route::post('/stones', 'StoneController@store');
        Route::post('/stones/sizes', 'StoneSizeController@store');
        Route::post('/stones/styles', 'StoneStyleController@store');
        Route::post('/stones/contours', 'StoneContourController@store');
            //Nomenclatures
             Route::post('/nomenclatures', 'NomenclatureController@store');

        //Jewels section
        Route::post('/jewels', 'JewelController@store');

        //Models section
        Route::post('/models', 'ModelController@store');

        //Materials type
        Route::post('/materialstypes', 'MaterialTypeController@store');
        Route::put('/materialstypes/{materialType}', 'MaterialTypeController@update');

        //expense types
        Route::get('/expensetypes/edit/{type}', 'ExpenseTypeController@edit');
        Route::post('/expensetypes', 'ExpenseTypeController@store');
        Route::put('/expensetypes/{type}', 'ExpenseTypeController@update');
    });

    Route::group(['middleware' => ['check_user_role:' . \App\Role\UserRole::ROLE_ADMIN]], function () {
        //Blog section
        Route::post('/blog', 'BlogController@store');
        Route::post('/blog/delete/{blog}', 'BlogController@destroy');

        //Expenses section
        Route::put('/expenses/{expense}', 'ExpenseController@update');
        Route::post('/expenses/delete/{expense}', 'ExpenseController@destroy');

        //Slides section
        Route::post('/slides', 'SliderController@store');
        Route::post('/slides/delete/{slider}', 'SliderController@destroy');
        Route::put('/slides/{slider}', 'SliderController@update');

        //Dailyreports section
        Route::post('/dailyreports/delete/{report}', 'DailyReportController@destroy');

        //Orders section
        Route::post('/orders/delete/{order}', 'OrderController@destroy');

        //Discounts section
        Route::post('discounts/delete/{discountCode}', 'DiscountCodeController@destroy');

        //Substitutions section
        Route::put('/users/substitutions/{userSubstitution}', 'UserSubstitutionController@update');
        Route::post('/users/substitutions/delete/{userSubstitution}', 'UserSubstitutionController@destroy');

        //Products section
        Route::post('/products/delete/{product}', 'ProductController@destroy');
        Route::put('/products/{product}', 'ProductController@update');

        //Products travelling section
        Route::post('/productstravelling/delete/{product}', 'ProductTravellingController@destroy');

        //Stones section
        Route::post('/stones/delete/{stone}', 'StoneController@destroy');
        Route::get('/stones/sizes/{stoneSize}', 'StoneSizeController@edit');
        Route::get('/stones/styles/{stoneStyle}', 'StoneStyleController@edit');
        Route::put('/stones/{stone}', 'StoneController@update');
        Route::get('/stones/{stone}', 'StoneController@edit');
        Route::post('/stones/{stone}/topUp', 'StoneController@topUp');
        Route::post('/stones/{stone}/decreaseQnty', 'StoneController@decreaseQnty');
        Route::get('/stones/contours/{stoneContour}', 'StoneContourController@edit');
        Route::post('/stones/sizes/delete/{stoneSize}', 'StoneSizeController@destroy');
        Route::post('/stones/styles/delete/{stoneStyle}', 'StoneStyleController@destroy');
        Route::post('/stones/contours/delete/{stoneContour}', 'StoneContourController@destroy');
        Route::put('/stones/sizes/{stoneSize}', 'StoneSizeController@update');
        Route::put('/stones/styles/{stoneStyle}', 'StoneStyleController@update');
        Route::put('/stones/contours/{stoneContour}', 'StoneContourController@update');
            //Nomenclatures
            Route::put('/nomenclatures/{nomenclature}', 'NomenclatureController@update');
            Route::post('/nomenclatures/delete/{nomenclature}', 'NomenclatureController@destroy');

        //Reviews section
        Route::post('/reviews/delete/{review}', 'ReviewController@destroy')->name('destroy_review');

        //Partners section
        Route::put('/partners/{partner}', 'PartnerController@update');
        Route::put('/partnermaterials/{partner}/{material}', 'PartnerMaterialController@update');

        //Repairs section
        Route::post('/repairtypes', 'RepairTypeController@store');
        Route::put('/repairtypes/{repairType}', 'RepairTypeController@update');
        Route::post('/repairtypes/delete/{repairType}', 'RepairTypeController@destroy');

        //Materials section
        Route::post('/materialstypes/delete/{materialType}', 'MaterialTypeController@destroy');
        Route::post('/materials', 'MaterialController@store');
        Route::post('/materials/delete/{material}', 'MaterialController@destroy');
        Route::put('/materials/{material}', 'MaterialController@update');

        //Jewels section
        Route::put('/jewels/{jewel}', 'JewelController@update');
        Route::post('/jewels/delete/{jewel}', 'JewelController@destroy');

        //Currencies
        Route::post('/settings/currencies', 'CurrencyController@store');
        Route::post('/settings/currencies/delete/{currency}', 'CurrencyController@destroy');
        Route::put('/settings/currencies/{currency}', 'CurrencyController@update');

        //Cashgroups
        Route::post('/settings/cashgroups/store', 'CashGroupController@store')->name('store_cashgroup');
        Route::put('/settings/cashgroups/{cashGroup}', 'CashGroupController@update');
        Route::post('/settings/cashgroups/delete/{cashGroup}', 'CashGroupController@destroy')->name('destroy_cashgroup');

        //Price section
        Route::post('/prices/{material}', 'PriceController@store');
        Route::post('/prices/delete/{price}', 'PriceController@destroy');
        Route::put('/prices/{price}', 'PriceController@update');

        //Models section
        Route::put('/models/{model}', 'ModelController@update');
        Route::post('/models/delete/{model}', 'ModelController@destroy');

        //Expenses types
        Route::post('/expensetypes/delete/{type}', 'ExpenseTypeController@destroy');

        Route::post('/filterInquiryDate', 'DailyReportController@filterInquiryDate');

        // Cash Register filter
        Route::post('/filterCashRegister', 'CashRegisterController@ajaxFilter');
    });

    //Print
    Route::get('/products/generatelabel/{barcode}', 'GenerateLabelController@generate');
    Route::get('/productsothers/generatelabel/{barcode}', 'ProductOtherController@generate');
    Route::get('/orders/print/{id}', 'OrderController@generate')->name('order_receipt');

    //Search
    Route::get('/search/repairs', 'RepairController@filter');
    Route::get('/search/repairs_types', 'RepairTypeController@filter');
    Route::get('/search/products_others_types', 'ProductOtherTypeController@filter');
    Route::get('/search/products_others', 'ProductOtherController@filter');
    Route::get('/search/orders/model', 'ModelOrderController@filter');
    Route::get('/search/orders/custom', 'CustomOrderController@filter');
    Route::get('/search/stones', 'StoneController@filter');
    Route::get('/search/materialquantities', 'MaterialQuantityController@filter');
    Route::get('/search/materials', 'MaterialController@filter');
    Route::get('/search/discounts', 'DiscountCodeController@filter');
    Route::get('/search/jewels', 'JewelController@filter');
    Route::get('/search/users', 'UserController@filter');
    Route::get('/search/orders/model', 'ModelOrderController@filter');
    Route::get('/search/orders/custom', 'CustomOrderController@filter');
    Route::get('/select_search/repairtypes', 'RepairTypeController@select_search');
    Route::get('/select_search/stones/nomenclatures', 'NomenclatureController@select_search');
    Route::get('/select_search/stones/sizes', 'StoneSizeController@select_search');
    Route::get('/select_search/stones/styles', 'StoneStyleController@select_search');
    Route::get('/select_search/stones/contours', 'StoneContourController@select_search');
    Route::get('/select_search/stores', 'StoreController@select_search');
    Route::get('/select_search/users', 'UserController@select_search');
    Route::get('/select_search/parentmaterials', 'MaterialController@select_search');
    Route::get('/select_materials/{type_id}', 'MaterialController@select_materials');
    Route::get('/select_material_prices/{id}', 'MaterialController@select_material_prices');
    Route::get('/select_search/global/materials/{type}', 'MaterialController@select_search_withPrice');
    Route::get('/select_search/materials', 'MaterialQuantityController@select_search');
    Route::get('/select_search/global/materials', 'MaterialController@select_search_withPrice');
    Route::get('/select_search/prices/materials', 'PriceController@select_search');
    Route::get('/select_search/jewels', 'JewelController@select_search');
    Route::get('/select_search/stones', 'StoneController@select_search');
    Route::get('/search/products', 'ProductController@filter');
    Route::get('/select_search/products', 'ProductController@select_search');
    Route::get('/search/models', 'ModelController@filter');
    Route::get('/select_search/models', 'ModelController@select_search');

    Route::post('/sell/partner', 'PaymentController@partner_payment');

    Route::get('/sell/order_materials', 'PaymentController@order_materials');

    Route::get('/cartMaterialsInfo', 'SellingController@cartMaterialsInfo')->name('cart_materials');

    Route::post('/mailchimp', 'NewsletterController@store');
    Route::post('/mailchimp/unsubscribe/{subscriber}', 'NewsletterController@destroy');

    Route::post('/orders', 'OrderController@store');
    Route::put('/orders/{order}', 'OrderController@update');
    Route::get('/orders/getProductInfo/{product}', 'OrderController@getProductInfo')->name('getProductInfo');
    Route::get('/orders/getModelInfo/{model}', 'OrderController@getModelInfo')->name('getModelInfo');
    Route::post('/orders/delete/{order}', 'OrderController@destroy');

    Route::put('/partners/{partner}', 'PartnerController@update');
    Route::put('/partnermaterials/{partner}/{material}', 'PartnerMaterialController@update');

    Route::get('productstravelling/addByScan/{product}', 'ProductTravellingController@addByScan');

    //Route::post('/blog/{article}/{comment}/delete', 'BlogCommentController@destroy');

    Route::post('/infophones', 'InfoPhoneController@store');
    Route::post('/infophones/delete/{phone}', 'InfoPhoneController@destroy');

    Route::post('/expenses', 'ExpenseController@store');

    Route::post('/dailyreports', 'DailyReportController@store');

    Route::post('/stores', 'StoreController@store');
    Route::put('/stores/{store}', 'StoreController@update');
    Route::get('/stores/{store}', 'StoreController@edit');
    Route::post('/stores/delete/{store}', 'StoreController@destroy');

    Route::post('/nomenclatureс/delete/{nomenclature}', 'NomenclatureController@destroy');

    Route::get('/selling/online/{selling}', 'OnlineSellingsController@edit');
    Route::put('/selling/online/{selling}', 'OnlineSellingsController@update');

    Route::put('/blog/{article}', 'BlogController@update');
    Route::post('/blog/{article}', 'BlogController@destroy');

    Route::post('/sendMaterial', 'MaterialTravellingController@store');

    Route::put('/users/{user}', 'UserController@update');

    Route::post('/users', 'UserController@store');
    Route::post('/users/delete/{user}', 'UserController@destroy');

    Route::post('/repairs', 'RepairController@store');

    Route::get('/repairs/return/{id}', 'RepairController@return');
    Route::put('/repairs/return/{id}', 'RepairController@returnRepair');

    Route::get('/repairs/edit/{barcode}', 'RepairController@edit');
    Route::put('/repairs/edit/{barcode}', 'RepairController@update');

    Route::get('/repairs/{barcode}', 'RepairController@scan');
    Route::get('/repairs/certificate/{id}', 'RepairController@certificate')->name('repair_receipt');
    Route::post('/repairs/delete/{repair}', 'RepairController@destroy');

    Route::put('/repairs/{repair}', 'RepairController@update');

    Route::get('/products/{model}', 'ProductController@chainedSelects');

    Route::post('/products', 'ProductController@store');

    Route::post('/productsotherstypes', 'ProductOtherTypeController@store');
    Route::put('/productsotherstypes/{productOtherType}', 'ProductOtherTypeController@update');
    Route::post('/productsotherstypes/delete/{productOtherType}', 'ProductOtherTypeController@destroy');

    Route::post('/productsothers', 'ProductOtherController@store');
    Route::put('/productsothers/{productOther}', 'ProductOtherController@update');
    Route::post('/productsothers/delete/{productOther}', 'ProductOtherController@destroy');

    Route::post('/sell/payment', 'PaymentController@store');

    Route::get('/getPrices/{material}/{model}', 'PriceController@getByMaterial');

    Route::get('/getPricesExchange/{material}/{model}', 'PriceController@getByMaterialExchange');

    Route::post('/gallery/delete/{photo}', 'GalleryController@destroy');

    Route::post('/materials/accept/{material}', 'MaterialTravellingController@accept');
    Route::post('/materials/decline/{material}', 'MaterialTravellingController@decline');
});

/**
 * Online Store Routes
 */
Route::group(['prefix' => 'online', 'namespace' => 'Store'], function() {
    Route::get('/', 'StoreController@index')->name('store');
    Route::post('/blog/{article}/comments/delete/{comment}', 'BlogCommentController@destroy');

    Route::group(['prefix' => 'blog'], function() {
        Route::get('/{article}', 'BlogController@show')->name('single_article');
        Route::get('/lg/{locale}', 'BlogController@index')->name('translated_articles');
        Route::get('/lg/{locale}/{article}', 'BlogController@show')->name('single_translated_article');
        Route::post('/{article}/comment', 'BlogCommentController@store')->name('article_comment');
        Route::post('/{article}/{comment}/delete', 'BlogCommentController@destroy')->name('article_comment_delete');
    });

    Route::get('/prices', 'StorePricesController@index')->name('storePrices');
    Route::get('/warranty', 'WarrantyController@index')->name('warranty');
    Route::get('/howtoorder', 'HowToOrderController@index')->name('howtoorder');
    Route::get('/about', 'AboutController@index')->name('about');
    Route::get('/stores', 'ListStoresController@index')->name('online_stores');

    Route::get('/contact', 'ContactController@index')->name('contactus');
    Route::post('/contact', 'ContactController@store');

    Route::post('/subscribe', 'SubscribeController@subscribe')->name('subscribe');
    Route::get('/unsubscribe/{email}', 'SubscribeController@unsubscribe')->name('unsubscribe');

    //User Related
    Route::get('/register', 'UserController@create')->name('register');
    Route::post('/register', 'UserController@store')->name('registerform');
    Route::get('/login', 'UserController@login')->name('login');
    Route::post('/login', 'UserController@userlogin')->name('userlogin');
    Route::get('/logout', 'UserController@logout')->name('logout');

    Route::get('/custom_order', 'CustomOrderController@index')->name('custom_order');
    Route::post('/custom_order', 'CustomOrderController@store')->name('submit_custom_order');

    Route::group(['prefix' => 'products'], function() {
        Route::get('/', 'ProductController@index')->name('products');
        Route::get('/{product}', 'ProductController@show')->name('single_product');
        Route::post('/{product}/review', 'ReviewController@store')->name('product_review');
    });

    Route::group(['prefix' => 'productsothers'], function() {
        Route::get('/', 'ProductOtherController@index')->name('productsothers');
        Route::get('/{product}', 'ProductOtherController@show')->name('single_product_other');
    });

    Route::group(['prefix' => 'models'], function() {
        Route::get('/', 'ModelController@index')->name('models');
        Route::get('/{model}', 'ModelController@show')->name('single_model');
    });

    Route::get('/model_orders/', 'ModelOrderController@index')->name('model_orders');

    Route::get('/cart', 'CartController@index')->name('cart');
    Route::get('/cart/addItem/{item}/{quantity}', 'CartController@addItem')->name('CartAddItem');
});

Route::group(['prefix' => 'online',  'namespace' => 'Store', 'middleware' => 'auth'], function() {
    Route::post('/cart', 'UserPaymentController@store')->name('pay_order');
    Route::post('/cart/pay/paypal', 'PayController@pay')->name('paypal_pay');
    Route::get('/cart/pay/status', 'PayController@getPaymentStatus')->name('paypal_status');
    Route::get('/cart/addDiscount/{barcode}', 'PayController@setDiscount')->name('add_discount');
    Route::get('/cart/removeDiscount/{name}', 'PayController@removeDiscount')->name('remove_discount');

    Route::get('/account', 'AccountController@index')->name('user_account');

    Route::get('/wishlist', 'WishListController@index')->name('wishlist');
    Route::get('/wishlist/delete/{wishList}', 'WishListController@destroy')->name('destroy_wishlist_item');

    Route::get('/settings', 'UserController@edit')->name('user_settings');
    Route::post('/settings', 'UserController@update')->name('user_settings_update');

    Route::get('/model_order/{model}', 'ModelOrderController@store')->name('order_model');

    //Route::get('/cart/updateItem/{item}/{quantity}', 'CartController@updateItem')->name('CartUpdateItem');

});

//AJAX FOR STORE

Route::group(['prefix' => 'ajax', 'namespace' => 'Store'], function() {
    //Route::get('/cart/addItem/{item}/{quantity}', 'CartController@addItem');
    Route::get('/cart/removeItem/{item}', 'CartController@removeItem')->name('CartRemoveItem');
    Route::get('/cart/updateItem/{item}/{quantity}', 'CartController@updateItem')->name('CartUpdateItem');

    Route::get('/products/{product}/quickview/', 'ProductController@quickview');
    Route::get('/productsothers/{product}/quickview/', 'ProductOtherController@quickview');
    Route::get('/models/{model}/quickview/', 'ModelController@quickview');

    Route::get('/filter/products', 'ProductController@filter');

    Route::get('/filter/productsothers', 'ProductOtherController@filter');

    Route::get('/filter/models', 'ModelController@filter');

    Route::post('/wishlists/store/{type}/{item}', 'WishListController@store')->name('wishlists_store');

    Route::get('/cart/setDiscount/{barcode}',  'CartController@setDiscount')->name('add_discount');

    Route::post('/search', 'StoreController@search');
});

