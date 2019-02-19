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

    Route::get('/infoemails', 'InfoMailController@index')->name('info_emails');
    Route::get('/infoemails/{email}', 'InfoMailController@edit');

    Route::get('/infophones', 'InfoPhoneController@index')->name('info_phones');
    Route::get('/infophones/{phone}', 'InfoPhoneController@edit');

    Route::get('/blog', 'BlogController@index')->name('admin_blog');
    Route::get('/blog/{article}', 'BlogController@edit');
    Route::get('/blog/{article}/comments', 'BlogController@showComments');
    Route::post('/blog', 'BlogController@store');
    Route::get('/sell/partner', 'PaymentController@partner_payment');

    Route::get('/cartMaterialsInfo', 'SellingController@cartMaterialsInfo')->name('cart_materials');

    Route::get('/repairtypes', 'RepairTypeController@index')->name('repair_types');
    Route::post('/repairtypes', 'RepairTypeController@store');
    Route::get('/repairtypes/{repairType}', 'RepairTypeController@edit');

    Route::get('/repairs', 'RepairController@index')->name('repairs');
    Route::post('/repairs', 'RepairController@store');
    Route::get('/repairs/{barcode}', 'RepairController@edit');

    Route::get('/selling', 'SellingController@index')->name('selling');
    Route::post('/selling', 'SellingController@store');

    Route::get('/selling/online', 'OnlineSellingsController@index')->name('online_selling');

    Route::get('/stones/sizes', 'StoneSizeController@index')->name('sizes');
    Route::post('/stones/sizes', 'StoneSizeController@store');

    Route::get('/stones/styles', 'StoneStyleController@index')->name('styles');
    Route::post('/stones/styles', 'StoneStyleController@store');

    Route::get('/stones/contours', 'StoneContourController@index')->name('contours');
    Route::post('/stones/contours', 'StoneContourController@store');

    Route::get('/orders', 'OrderController@index')->name('orders');

    //Route::get('/users/substitution/{user}', 'UserSubstitutionController@show');

    Route::get('/users/substitutions', 'UserSubstitutionController@index')->name('substitutions');
    Route::get('/users/substitutions/{userSubstitution}', 'UserSubstitutionController@edit');

    Route::get('/users', 'UserController@index')->name('users');
    Route::get('/users/{user}', 'UserController@edit');

    Route::get('/partners', 'PartnerController@index')->name('partners');
    Route::get('/partners/{partner}', 'PartnerController@edit');

    Route::get('/partnermaterials/{partner}', 'PartnerMaterialController@index')->name('partner_materials');
    Route::get('/partnermaterials/{partner}/{material}', 'PartnerMaterialController@edit');

    Route::get('/stones', 'StoneController@index')->name('stones');
    Route::post('/stones', 'StoneController@store');

    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::get('/slides', 'SliderController@index')->name('slides');
    Route::post('/slides', 'SliderController@store');

    Route::get('/slides/{slide}', 'SliderController@edit');

    Route::get('/stores', 'StoreController@index')->name('stores');
    Route::post('/stores', 'StoreController@store');
    Route::get('/stores/info/{store}', 'StoreController@show');

    Route::get('/payments', 'PaymentController@index')->name('payments');

    Route::get('/stores/{store}', 'StoreController@edit');
    //Route::put('/stores/{store}', 'StoreController@update');

    Route::get('/selling/online/{selling}', 'OnlineSellingsController@edit');
    Route::put('/selling/online/{selling}', 'OnlineSellingsController@update');

    Route::get('/nomenclatures', 'NomenclatureController@index')->name('nomenclatures');

    Route::get('/nomenclatures/{nomenclature}', 'NomenclatureController@edit');

    Route::get('/materials', 'MaterialController@index')->name('materials');
    Route::post('/materials', 'MaterialController@store');

    Route::get('/materialstypes', 'MaterialTypeController@index')->name('materials_types');
    Route::post('/materialstypes', 'MaterialTypeController@store');

    Route::get('/materialstypes/{materialType}', 'MaterialTypeController@edit');

    Route::get('/materials/{material}', 'MaterialController@edit');
    Route::put('/materials/{material}', 'MaterialController@update');

    Route::post('/materials/accept/{material}', 'MaterialTravellingController@accept');
    Route::post('/materials/decline/{material}', 'MaterialTravellingController@decline');

    Route::get('/mquantity', 'MaterialQuantityController@index')->name('materials_quantity');
    Route::post('/mquantity', 'MaterialQuantityController@store');

    Route::get('/mtravelling', 'MaterialTravellingController@index')->name('materials_travelling');
    Route::post('/mtravelling', 'MaterialTravellingController@store');

    Route::get('/mquantity/{materialQuantity}', 'MaterialQuantityController@edit');

    Route::get('/prices', 'PriceController@index')->name('prices');
    Route::post('/prices', 'PriceController@index');

    Route::get('/prices/{material}', 'PriceController@show')->name('view_price');
    Route::post('/prices/{material}', 'PriceController@store');

    Route::get('/prices/edit/{price}', 'PriceController@edit');

    Route::get('/jewels', 'JewelController@index')->name('jewels');
    Route::post('/jewels', 'JewelController@store');

    Route::get('/jewels/{jewel}', 'JewelController@edit');

    Route::get('/orders/custom', 'CustomOrderController@index')->name('custom_orders');

    Route::get('/orders/custom/{order}', 'CustomOrderController@edit');

    Route::get('/orders/model', 'ModelOrderController@index')->name('model_orders_web');
    
    Route::get('/orders/model/{order}', 'ModelOrderController@edit');

    Route::get('/models', 'ModelController@index')->name('admin_models');
    Route::post('/models', 'ModelController@store');

    Route::get('/models/{model}', 'ModelController@edit');
    Route::put('/models/{model}', 'ModelController@update');

    Route::get('/products/{product}', 'ProductController@edit');
    Route::get('/products', 'ProductController@index')->name('admin_products');
    Route::post('/products', 'ProductController@store');

    Route::get('/productsothers', 'ProductOtherController@index')->name('products_others');
    Route::get('/productsothers/{productOther}', 'ProductOtherController@edit');
    //Route::put('/productsothers/{product}', 'ProductOtherController@update');

    Route::get('/productstravelling', 'ProductTravellingController@index')->name('products_travelling');

    Route::post('/productstravelling', 'ProductTravellingController@store');

    Route::get('/productstravelling/accept/{product}', 'ProductTravellingController@accept');

    Route::get('productstravelling/addByScan/{product}', 'ProductTravellingController@addByScan');

    Route::get('/productsotherstypes', 'ProductOtherTypeController@index')->name('products_others_types');
    Route::get('/productsotherstypes/{productOtherType}', 'ProductOtherTypeController@edit');

    Route::get('/settings', 'SettingController@index')->name('settings');
    Route::post('/settings', 'SettingController@store');

    Route::get('/settings/stock', 'SettingController@stockPrices')->name('stock_prices');
    Route::post('/settings/stock', 'SettingController@updatePrices');

    Route::get('/settings/currencies', 'SettingController@currencies')->name('currencies');
    Route::post('/settings/currencies', 'CurrencyController@store');

    Route::get('/settings/currencies/{currency}', 'CurrencyController@edit');

    Route::get('/settings/cashgroups', 'CashGroupController@index')->name('cashgroups');
    Route::get('/settings/cashgroups/{cashGroup}', 'CashGroupController@edit');

    Route::get('/discounts', 'DiscountCodeController@index')->name('discounts');

    Route::get('/discounts/{discountCode}', 'DiscountCodeController@edit');

    Route::get('/setDiscount/{barcode}',  'SellingController@setDiscount');

    Route::get('/sell/clearCart', 'SellingController@clearCart')->name('clear_cart');

    Route::get('/stones/sizes/{stoneSize}', 'StoneSizeController@edit');

    Route::get('/stones/styles/{stoneStyle}', 'StoneStyleController@edit');

    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::get('/stones/contours/{stoneContour}', 'StoneContourController@edit');

    Route::get('/repairs/certificate/{barcode}', 'RepairController@certificate');

    Route::get('/repairs/return/{repair}', 'RepairController@return');
    Route::get('/repairs/edit/{repair}', 'RepairController@edit');

    Route::get('/mailchimp', 'NewsletterController@index')->name('mailchimp');

    Route::get('/reviews', 'ReviewController@index')->name('reviews');
    Route::get('/reviews/{review}', 'ReviewController@show')->name('show_review');
    Route::post('/reviews/delete/{review}', 'ReviewController@destroy')->name('destroy_review');

    Route::get('/reviews/product/{product}', 'ReviewController@index')->name('show_product_reviews');

    Route::get('/products/reviews/all', 'ProductController@showReviews')->name('products_reviews');
    Route::get('/productsothers/reviews/all', 'ProductOtherController@showReviews')->name('show_products_others_reviews');
    Route::get('/models/reviews/all', 'ModelController@showReviews')->name('show_model_reviews');
    Route::post('/logout', 'UserController@logout')->name('admin_logout');

    Route::get('/orders/{order}', 'OrderController@edit');
    Route::get('/expenses', 'ExpenseController@index')->name('expenses');   
    Route::get('/expenses/{expense}', 'ExpenseController@edit');    

    Route::get('/expensetypes', 'ExpenseTypeController@index')->name('expenses_types'); 
    Route::get('/expensetypes/edit/{type}', 'ExpenseTypeController@edit');   

    Route::get('/dailyreports', 'DailyReportController@index')->name('daily_reports'); 
    Route::get('/dailyreports/create', 'DailyReportController@create')->name('create_report');
          
    Route::post('/dailyreports/create/moneyreport', 'DailyReportController@moneyreport');
    Route::post('/dailyreports/create/jewelreport', 'DailyReportController@jewelreport');
    Route::post('/dailyreports/create/materialreport', 'DailyReportController@materialreport');

    Route::get('/dailyreports/{report}', 'DailyReportController@edit');

    Route::get('/safe', 'SafeController@index');
});

Route::group(['prefix' => 'ajax'], function() {
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

    Route::get('/select_search/repairtypes', 'RepairTypeController@select_search');

    Route::get('/select_search/stones/nomenclatures', 'NomenclatureController@select_search');

    Route::get('/select_search/stones/sizes', 'StoneSizeController@select_search');

    Route::get('/select_search/stones/styles', 'StoneStyleController@select_search');

    Route::get('/select_search/stones/contours', 'StoneContourController@select_search');

    Route::get('/select_search/stores', 'StoreController@select_search');

    Route::get('/select_search/users', 'UserController@select_search');

    Route::get('/select_search/parentmaterials', 'MaterialController@select_search');

    Route::get('/select_search/global/materials/{type}', 'MaterialController@select_search');

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

    Route::get('productstravelling/addByScan/{product}', 'ProductTravellingController@addByScan');

    //Route::post('/blog/{article}/{comment}/delete', 'BlogCommentController@destroy');

    Route::post('/infophones', 'InfoPhoneController@store');
    Route::post('/infophones/delete/{phone}', 'InfoPhoneController@destroy');

    Route::post('/infoemails', 'InfoEmailController@store');
    Route::post('/infoemails/delete/{phone}', 'InfoEmailController@destroy');

    Route::post('/slides', 'SliderController@store');
    Route::post('/slides/delete/{slide}', 'SliderController@destroy');

    Route::post('/blog', 'BlogController@store');
    Route::post('/blog/delete/{blog}', 'BlogController@destroy');
    Route::post('/expenses', 'ExpenseController@store');
    Route::put('/expenses/{expense}', 'ExpenseController@update');
    Route::post('/expenses/delete/{expense}', 'ExpenseController@destroy');

    Route::post('/dailyreports', 'DailyReportController@store');

    Route::get('/expensetypes/edit/{type}', 'ExpenseTypeController@edit');   
    Route::post('/expensetypes', 'ExpenseTypeController@store');
    Route::put('/expensetypes/{type}', 'ExpenseTypeController@update');
    Route::post('/expensetypes/delete/{type}', 'ExpenseTypeController@destroy');

    Route::post('/stores', 'StoreController@store');
    Route::put('/stores/{store}', 'StoreController@update');
    Route::get('/stores/{store}', 'StoreController@edit');
    Route::post('/stores/delete/{store}', 'StoreController@destroy');

    Route::post('/nomenclatureс/delete/{nomenclature}', 'NomenclatureController@destroy');

    Route::post('/materials', 'MaterialController@store');
    Route::post('/materials/delete/{material}', 'MaterialController@destroy');

    Route::post('/materialstypes', 'MaterialTypeController@store');
    Route::post('/materialstypes/delete/{materialType}', 'MaterialTypeController@destroy');

    Route::post('/repairtypes', 'RepairTypeController@store');

    Route::get('/selling/online/{selling}', 'OnlineSellingsController@edit');
    Route::put('/selling/online/{selling}', 'OnlineSellingsController@update');

    Route::post('/stones', 'StoneController@store');
    Route::post('/stones/delete/{stone}', 'StoneController@destroy');

    Route::post('/stones/sizes', 'StoneSizeController@store');
    Route::get('/stones/sizes/{stoneSize}', 'StoneSizeController@edit');

    Route::post('/stones/styles', 'StoneStyleController@store');
    Route::get('/stones/styles/{stoneStyle}', 'StoneStyleController@edit');

    Route::put('/blog/{article}', 'BlogController@update');
    Route::post('/blog/{article}', 'BlogController@destroy');

    Route::put('/stones/{stone}', 'StoneController@update');
    Route::get('/stones/{stone}', 'StoneController@edit');

    Route::post('/stones/contours', 'StoneContourController@store');
    Route::get('/stones/contours/{stoneContour}', 'StoneContourController@edit');

    Route::post('/stones/sizes/delete/{stoneSize}', 'StoneSizeController@destroy');
    Route::post('/stones/styles/delete/{stoneStyle}', 'StoneStyleController@destroy');
    Route::post('/stones/contours/delete/{stoneContour}', 'StoneContourController@destroy');

    Route::put('/stones/sizes/{stoneSize}', 'StoneSizeController@update');
    Route::put('/stones/styles/{stoneStyle}', 'StoneStyleController@update');
    Route::put('/stones/contours/{stoneContour}', 'StoneContourController@update');

    Route::post('/prices/{material}', 'PriceController@store');
    Route::post('/prices/delete/{price}', 'PriceController@destroy');
    Route::put('/prices/{price}', 'PriceController@update');

    Route::post('/jewels', 'JewelController@store');
    Route::put('/jewels/{jewel}', 'JewelController@update');
    Route::post('/jewels/delete/{jewel}', 'JewelController@destroy');

    Route::post('/models', 'ModelController@store');
    Route::put('/models/{model}', 'ModelController@update');
    Route::post('/models/delete/{model}', 'ModelController@destroy');

    Route::post('/mquantity', 'MaterialQuantityController@store');
    Route::post('/mquantity/delete/{materialQuantity}', 'MaterialQuantityController@destroy');

    Route::post('/mquantity/deletebymaterial/{material}', 'MaterialQuantityController@deleteByMaterial');

    Route::post('/sendMaterial', 'MaterialTravellingController@store');

    Route::put('/mquantity/{materialQuantity}', 'MaterialQuantityController@update');

    Route::put('/materials/{material}', 'MaterialController@update');

    Route::put('/materialstypes/{materialType}', 'MaterialTypeController@update');

    Route::put('/users/{user}', 'UserController@update');

    Route::put('/orders/custom/{order}', 'CustomOrderController@update');
    Route::put('/orders/model/{order}', 'ModelOrderController@update');

    Route::post('/users', 'UserController@store');
    Route::post('/users/delete/{user}', 'UserController@destroy');

    //Route::put('/users/substitutions/{user}', 'UserSubstitutionController@store');

    Route::post('/repairs', 'RepairController@store');

    Route::get('/repairs/return/{barcode}', 'RepairController@return');
    Route::put('/repairs/return/{barcode}', 'RepairController@returnRepair');

    Route::get('/repairs/edit/{barcode}', 'RepairController@edit');
    Route::put('/repairs/edit/{barcode}', 'RepairController@update');

    Route::get('/repairs/{barcode}', 'RepairController@scan');
    Route::get('/repairs/certificate/{id}', 'RepairController@certificate');
    Route::post('/repairs/delete/{repair}', 'RepairController@destroy');

    Route::put('/repairtypes/{repairType}', 'RepairTypeController@update');
    Route::post('/repairtypes/delete/{repairType}', 'RepairTypeController@destroy');

    Route::put('/repairs/{repair}', 'RepairController@update');

    Route::post('/discounts', 'DiscountCodeController@store');
    Route::put('/discounts/{discountCode}', 'DiscountCodeController@update');

    Route::get('/products/{model}', 'ProductController@chainedSelects');

    Route::post('/products', 'ProductController@store');
    Route::post('/products/delete/{product}', 'ProductController@destroy');
    Route::put('/products/{product}', 'ProductController@update');

    Route::post('/productstravelling', 'ProductTravellingController@store');

    Route::post('/productstravelling/delete/{product}', 'ProductTravellingController@destroy');

    Route::post('/productsotherstypes', 'ProductOtherTypeController@store');
    Route::put('/productsotherstypes/{productOtherType}', 'ProductOtherTypeController@update');
    Route::post('/productsotherstypes/delete/{productOtherType}', 'ProductOtherTypeController@destroy');

    Route::post('/productsothers', 'ProductOtherController@store');
    Route::put('/productsothers/{productOther}', 'ProductOtherController@update');
    Route::post('/productsothers/delete/{productOther}', 'ProductOtherController@destroy');

    Route::get('discounts/check/{barcode}', 'DiscountCodeController@check');
    Route::post('discounts/delete/{discountCode}', 'DiscountCodeController@destroy');

    Route::post('/sell', 'SellingController@sell')->name('sellScan');
    Route::get('/setDiscount/{barcode}',  'SellingController@setDiscount')->name('add_discount');
    Route::get('/removeDiscount/{name}',  'SellingController@removeDiscount')->name('remove_discount');
    Route::post('/sendDiscount',  'SellingController@sendDiscount')->name('send_discount');
    Route::get('/sellings/information', 'SellingController@printInfo');

    Route::post('/sell/removeItem/{item}', 'SellingController@removeItem');

    Route::post('/sell/payment', 'PaymentController@store');

    //Route::post('/sell/partner', 'PaymentController@partner_payment');

    Route::post('/settings/currencies', 'CurrencyController@store');
    Route::post('/settings/currencies/delete/{currency}', 'CurrencyController@destroy');
    Route::put('/settings/currencies/{currency}', 'CurrencyController@update');

    Route::put('/settings/cashgroups/{cashGroup}', 'CashGroupController@update');

    Route::get('/getPrices/{material}/{model}', 'PriceController@getByMaterial');

    Route::get('/getPricesExchange/{material}/{model}', 'PriceController@getByMaterialExchange');

    Route::post('/users/substitutions', 'UserSubstitutionController@store');

    Route::put('/users/substitutions/{userSubstitution}', 'UserSubstitutionController@update');
    Route::post('/users/substitutions/delete/{userSubstitution}', 'UserSubstitutionController@destroy');

    Route::post('/gallery/delete/{photo}', 'GalleryController@destroy');

    Route::post('/reviews/delete/{review}', 'ReviewController@destroy')->name('destroy_review');

    Route::post('/blog/comments/{comment}/delete', 'BlogCommentController@destroy');

    Route::post('/materials/accept/{material}', 'MaterialTravellingController@accept');
    Route::post('/materials/decline/{material}', 'MaterialTravellingController@decline');

    Route::post('/nomenclatures', 'NomenclatureController@store');
    Route::put('/nomenclatures/{nomenclature}', 'NomenclatureController@update');
    Route::post('/nomenclatures/delete/{nomenclature}', 'NomenclatureController@destroy');
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
    Route::get('/stores', 'ListStoresController@index')->name('stores');

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
});

Route::group(['prefix' => 'online',  'namespace' => 'Store', 'middleware' => 'auth'], function() {
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::post('/cart', 'UserPaymentController@store')->name('pay_order');
    Route::get('/cart/addItem/{item}/{quantity}', 'CartController@addItem')->name('CartAddItem');
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

});

/**
 * !Note: Store routes for testing
 */
// Route::prefix('online')->group(function () {

//     Route::get('contact', function () {
//         return view('store.pages.contact');
//     });

//     Route::get('product', function () {
//         return view('store.pages.products.index');
//     });
// });