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



//Auth::routes();

/*
 * Authentiocation routes
 */


Route::group(['namespace' => 'Auth'], function()
{

    Route::get('login', 'LoginController@index');
    Route::post('login', [ 'as' => 'login', 'uses' => 'LoginController@login']);

    Route::post('logout', 'LoginController@logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');

    //Route::get('register', 'RegisterController@showRegistrationForm');
    //Route::post('register', 'RegisterController@register');

    /*Route::get('auth/{provider}', 'LoginController@provider');
    Route::get('auth/{provider}/callback', 'LoginController@providerCallback');*/

});


Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'auth'], function()
{

    /* Permission */
    Route::resource('/permission', 'PermissionController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'permission', ['uses' => 'PermissionController@index']);

    Route::post('/user/permission', ['as' => 'user-permission','uses' => 'PermissionController@store']);

    Route::any('/permission/delete/{id}', [ 'as' => 'permission-delete', 'uses' => 'PermissionController@delete']);


    /*Role*/
    Route::resource('/role', 'RoleController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'role', ['uses' => 'RoleController@index']);

    Route::post('/user/role', ['as' => 'user-role','uses' => 'RoleController@store']);

    Route::any('/role/delete/{id}', [ 'as' => 'role-delete', 'uses' => 'RoleController@delete']);


    /*User*/
    Route::resource('/user', 'UserController', [ 'except' => ['index', 'create', 'store'] ]);

    Route::match(['get', 'post'], 'user', ['uses' => 'UserController@index']);


    Route::get('/user/create', ['uses' => 'UserController@create', 'middleware' => ['role:super-administrator']]);

    Route::post('user/store', ['uses' => 'UserController@store', 'middleware' => ['role:super-administrator']]);


    Route::any('/user/delete/{id}', [ 'as' => 'user-delete', 'uses' => 'UserController@delete']);




    /*service-location*/
    Route::resource('/service-center',  'ServiceCenterController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'service-center', ['uses' => 'ServiceCenterController@index']);

    Route::post('/service-center/store', ['as' => 'service-center','uses' => 'ServiceCenterController@store']);

    Route::any('/service-center/delete/{id}', [ 'as' => 'service-center-delete', 'uses' => 'ServiceCenterController@delete']);


    /*service-package*/

    Route::resource('/service-package',  'ServicePackageController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'service-package', ['uses' => 'ServicePackageController@index']);

    Route::post('/service-package/store', ['as' => 'service-package','uses' => 'ServicePackageController@store']);

    Route::any('/service-package/delete/{id}', [ 'as' => 'service-package-delete', 'uses' => 'ServicePackageController@delete']);


    /*vehicle-type*/
    Route::resource('/vehicle-type',  'VehicleTypeController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'vehicle-type', ['uses' => 'VehicleTypeController@index']);

    Route::post('/vehicle-type/store', ['as' => 'vehicle-type','uses' => 'VehicleTypeController@store']);

    Route::any('/vehicle-type/delete/{id}', [ 'as' => 'vehicle-type-delete', 'uses' => 'VehicleTypeController@delete']);


    /*Vehicle Model*/
    Route::resource('/vehicle-model',  'VehicleModelController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'vehicle-model', ['uses' => 'VehicleModelController@index']);

    Route::post('/vehicle-model/store', ['as' => 'vehicle-model','uses' => 'VehicleModelController@store']);

    Route::any('/vehicle-model/delete/{id}', [ 'as' => 'vehicle-model-delete', 'uses' => 'VehicleModelController@delete']);


    /*Vehicle*/

    Route::resource('/vehicle',  'VehicleController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'vehicle', ['uses' => 'VehicleController@index']);

    Route::post('/vehicle/store', ['as' => 'vehicle','uses' => 'VehicleController@store']);

    Route::any('/vehicle/delete/{id}', [ 'as' => 'vehicle-delete', 'uses' => 'VehicleController@delete']);

    Route::any('/vehicle-image/{id}', [ 'as' => 'vehicle-image', 'uses' => 'VehicleController@vehicle_image']);


    /*Vehicle brands*/

    Route::resource('/brand',  'BrandController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'brand', ['uses' => 'BrandController@index']);

    Route::post('/brand/store', ['as' => 'brand','uses' => 'BrandController@store']);

    Route::any('/brand/delete/{id}', [ 'as' => 'brand-delete', 'uses' => 'BrandController@delete']);


   /*spare parts category*/

   /* Route::resource('/spare-parts-category',  'SparePartsCategoryController');

    Route::any('/spare-parts-category/delete/{id}', [ 'as' => 'spare-parts-category-delete', 'uses' => 'SparePartsCategoryController@delete']);*/


    /*Spare parts*/

    Route::resource('/spare-parts',  'SparePartsController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'spare-parts', ['uses' => 'SparePartsController@index']);

    Route::post('/spare-parts/store', ['as' => 'spare-parts','uses' => 'SparePartsController@store']);

    Route::any('/spare-parts/delete/{id}', [ 'as' => 'spare-parts-delete', 'uses' => 'SparePartsController@delete']);


    /*Brochure*/

    Route::resource('/brochure',  'BrochureController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'brochure', ['uses' => 'BrochureController@index']);

    Route::post('/brochure/store', ['as' => 'brochure','uses' => 'BrochureController@store']);

    Route::any('/brochure/delete/{id}', [ 'as' => 'brochure-delete', 'uses' => 'BrochureController@delete']);


    /*EDoc Type*/

    Route::resource('/e-doc-type',  'EDocTypeController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'e-doc-type', ['uses' => 'EDocTypeController@index']);

    Route::post('/e-doc-type/store', ['as' => 'e-doc-type','uses' => 'EDocTypeController@store']);

    Route::any('/e-doc-type/delete/{id}', [ 'as' => 'e-doc-type-delete', 'uses' => 'EDocTypeController@delete']);

    /*E Documents*/

    Route::resource('/e-documents',  'EDocumentController');

    Route::match(['get', 'post'], 'e-documents', ['uses' => 'EDocumentController@index']);

    Route::post('/e-documents/store', ['as' => 'e-documents','uses' => 'EDocumentController@store']);

    Route::any('/e-documents/delete/{id}', [ 'as' => 'e-documents-delete', 'uses' => 'EDocumentController@delete']);


    /*Faq*/

    Route::resource('/faq',  'FaqController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'faq', ['uses' => 'FaqController@index']);

    Route::post('/faq/store', ['as' => 'faq','uses' => 'FaqController@store']);

    Route::any('/faq/delete/{id}', [ 'as' => 'faq-delete', 'uses' => 'FaqController@delete']);

   /*News Events*/

    Route::resource('/news-events',  'NewsEventsController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'news-events', ['uses' => 'NewsEventsController@index']);

    Route::post('/news-events/store', ['as' => 'news-events','uses' => 'NewsEventsController@store']);

    Route::any('/news-events/delete/{id}', [ 'as' => 'news-events-delete', 'uses' => 'NewsEventsController@delete']);


    /*Promotions*/
    Route::resource('/promotions',  'PromotionController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'promotions', ['uses' => 'PromotionController@index']);

    Route::post('/promotions/store', ['as' => 'promotions','uses' => 'PromotionController@store']);

    Route::any('/promotions/delete/{id}', [ 'as' => 'promotions-delete', 'uses' => 'PromotionController@delete']);


    /*Service History*/

    Route::resource('/service-history',  'ServiceHistoryController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'service-history', ['uses' => 'ServiceHistoryController@index']);


    /*service_request*/

    Route::resource('/service-request', 'ServiceRequestController', ['except' => ['index']]);

    Route::match(['get', 'post'], 'service-request', ['uses' => 'ServiceRequestController@index']);



});





/*------test------*/



