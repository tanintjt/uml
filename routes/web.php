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
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm');
    Route::post('password/reset', 'ForgotPasswordController@reset');
    Route::get('password/reset/{token}', 'ForgotPasswordController@showResetForm');

    Route::get('register', 'RegisterController@showRegistrationForm');
    Route::post('register', 'RegisterController@register');

    Route::get('auth/{provider}', 'LoginController@provider');
    Route::get('auth/{provider}/callback', 'LoginController@providerCallback');

});


Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function()
{
    Route::resource('/permission', 'PermissionController');
    Route::resource('/role', 'RoleController');
    Route::resource('/user', 'UserController');

    Route::any('/user/delete/{id}', [ 'as' => 'user-delete', 'uses' => 'UserController@delete']);

    Route::any('/role/delete/{id}', [ 'as' => 'role-delete', 'uses' => 'RoleController@delete']);

    Route::any('/permission/delete/{id}', [ 'as' => 'permission-delete', 'uses' => 'PermissionController@delete']);

    /*service-location*/
    Route::resource('/service-center',  'ServiceCenterController');

    Route::any('/service-center/delete/{id}', [ 'as' => 'service-center-delete', 'uses' => 'ServiceCenterController@delete']);

    /*service-package*/

    Route::resource('/service-package',  'ServicePackageController');

    Route::any('/service-package/delete/{id}', [ 'as' => 'service-package-delete', 'uses' => 'ServicePackageController@delete']);

    /*vehicle-type*/

    Route::resource('/vehicle-type',  'VehicleTypeController');

    Route::any('/vehicle-type/delete/{id}', [ 'as' => 'vehicle-type-delete', 'uses' => 'VehicleTypeController@delete']);

    /*Vehicle Model*/

    Route::resource('/vehicle-model',  'VehicleModelController');

    Route::any('/vehicle-model/delete/{id}', [ 'as' => 'vehicle-model-delete', 'uses' => 'VehicleModelController@delete']);


    /*Vehicle*/

    Route::resource('/vehicle',  'VehicleController');

    Route::any('/vehicle/delete/{id}', [ 'as' => 'vehicle-delete', 'uses' => 'VehicleController@delete']);
    Route::any('/vehicle-image/{id}', [ 'as' => 'vehicle-image', 'uses' => 'VehicleController@vehicle_image']);


    /*Vehicle brands*/

    Route::resource('/brand',  'BrandController');

    Route::any('/brand/delete/{id}', [ 'as' => 'brand-delete', 'uses' => 'BrandController@delete']);


   /*spare parts category*/

    Route::resource('/spare-parts-category',  'SparePartsCategoryController');

    Route::any('/spare-parts-category/delete/{id}', [ 'as' => 'spare-parts-category-delete', 'uses' => 'SparePartsCategoryController@delete']);


    /*Spare parts*/

    Route::resource('/spare-parts',  'SparePartsController');

    Route::any('/spare-parts/delete/{id}', [ 'as' => 'spare-parts-delete', 'uses' => 'SparePartsController@delete']);


    /*Brochure*/

    Route::resource('/brochure',  'BrochureController');

    Route::any('/brochure/delete/{id}', [ 'as' => 'brochure-delete', 'uses' => 'BrochureController@delete']);


    /*EDoc Type*/

    Route::resource('/e-doc-type',  'EDocTypeController');

    Route::any('/e-doc-type/delete/{id}', [ 'as' => 'e-doc-type-delete', 'uses' => 'EDocTypeController@delete']);

    /*E Documents*/
    Route::resource('/e-documents',  'EDocumentController');

    Route::any('/e-documents/delete/{id}', [ 'as' => 'e-documents-delete', 'uses' => 'EDocumentController@delete']);


    /*Faq*/

    Route::resource('/faq',  'FaqController');

    Route::any('/faq/delete/{id}', [ 'as' => 'faq-delete', 'uses' => 'FaqController@delete']);

   /*News Events*/

    Route::resource('/news-events',  'NewsEventsController');

    Route::any('/news-events/delete/{id}', [ 'as' => 'news-events-delete', 'uses' => 'NewsEventsController@delete']);


    /*Promotions*/
    Route::resource('/promotions',  'PromotionController');

    Route::any('/promotions/delete/{id}', [ 'as' => 'promotions-delete', 'uses' => 'PromotionController@delete']);


    /*Service History*/

    Route::resource('/service-history',  'ServiceHistoryController');
});





/*------test------*/



