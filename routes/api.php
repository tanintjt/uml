<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::get('abc', function () {
    return 'Hello World';
});*/


/*Route::middleware('auth:api')->get('/api/user', function (Request $request) {
    return $request->user();
});*/

Route::get('date', [ 'as' => 'test', 'uses' => 'TestController@index']);



Route::post('api/auth', 'Api\V1\LoginController@provider');
//Route::get('api/auth/{provider}/callback', 'Api\V1\LoginController@providerCallback');

Route::post('/api/register', 'Api\V1\LoginController@register');

Route::post('/api/password/email', 'Api\V1\ForgotPasswordController@sendResetLinkEmail');

/*brand*/
Route::get('api/brand', [ 'as' => 'brand', 'uses' => 'Api\V1\BrandController@index']);

/*service package*/
Route::get('api/service-package-type', [ 'as' => 'service-package-type',
    'uses' => 'Api\V1\ServicePackageTypeController@index']);

Route::post('api/service-package', [ 'as' => 'service-package', 'uses' => 'Api\V1\ServicePackageController@index']);


Route::get('api/faqs', [ 'as' => 'service-request', 'uses' => 'Api\V1\FaqController@index']);
//Route::post('/faq-store', [ 'as' => 'service-request', 'uses' => 'FaqController@store']);

/*Vehicle*/
Route::get('api/vehicle', [ 'as' => 'vehicle', 'uses' => 'Api\V1\VehicleController@index']);

/*Brochure*/
Route::get('api/brochure', [ 'as' => 'brochure', 'uses' => 'Api\V1\BrochureController@index']);

/*news & events..*/
Route::get('api/news-events', [ 'as' => 'news-events', 'uses' => 'Api\V1\NewsEventsController@index']);

/* promotions*/
Route::get('api/promotion', [ 'as' => 'promotion', 'uses' => 'Api\V1\PromotionController@index']);

/*Spare Parts..*/

Route::get('api/spare-parts', [ 'as' => 'spare-parts', 'uses' => 'Api\V1\SparePartsController@index']);




/*location*/
Route::get('api/service-center', [ 'as' => 'service-center', 'uses' => 'Api\V1\ServiceCenterController@index']);

Route::post('api/min-distance',[ 'as' => 'min-distance', 'uses' => 'Api\V1\ServiceCenterController@distanceCalculation']);


Route::group(['prefix'=>'api','namespace' => 'Api\V1','middleware' => 'auth.basic'], function () {

    /*basic :auth */

//    Route::post('/register', 'LoginController@register');
    Route::post('/login', 'LoginController@login');

    Route::post('/logout', 'LoginController@logout');


    /*Services....... */

    /*Route::get('/service-center', [ 'as' => 'service-center', 'uses' => 'ServiceCenterController@index']);*/


    Route::post('/service-request', [ 'as' => 'service-request', 'uses' => 'ServiceRequestController@store']);

    /*Route::post('/min-distance',[ 'as' => 'min-distance', 'uses' => 'ServiceCenterController@distanceCalculation']);*/


    Route::post('/vc-store', [ 'as' => 'vc-store', 'uses' => 'VehicleCatalogController@store']);

    Route::post('/vehicle-catalog', [ 'as' => 'vehicle-catalog', 'uses' => 'VehicleCatalogController@index']);


    /*E Doc Type*/
    Route::get('/doc-type', [ 'as' => 'doc-type', 'uses' => 'EDocTypeController@index']);
    Route::post('/doc-type-store', [ 'as' => 'doc-type-store', 'uses' => 'EDocTypeController@store']);




    /*E Document*/

    Route::get('/docs', [ 'as' => 'docs', 'uses' => 'EDocumentController@index']);

    Route::post('/docs-store', [ 'as' => 'docs-store', 'uses' => 'EDocumentController@findOrCreateDocument']);


    //Route::post('/docs/{id}/update', [ 'as' => 'docs-update', 'uses' => 'EDocumentController@update']);

    /*promotion*/

    Route::post('/promotion-store', [ 'as' => 'promotion-store', 'uses' => 'PromotionController@store']);

    Route::post('/brochure-store', [ 'as' => 'brochure-store', 'uses' => 'BrochureController@store']);

    /*news & events..*/
    /*Route::get('/news-events', [ 'as' => 'news-events', 'uses' => 'NewsEventsController@index']);*/

    Route::post('/store-news-events', [ 'as' => 'store-news-events', 'uses' => 'NewsEventsController@store']);

    /*device_info*/
    Route::post('/device-info', [ 'as' => 'device-info', 'uses' => 'LoginController@device_info']);


    /*user profile*/
    Route::get('/user-profile', [ 'as' => 'user-profile', 'uses' => 'UserController@user_profile']);

    /*profile image*/
    Route::post('/update-profile', [ 'as' => 'profile-image', 'uses' => 'UserController@update_profile']);

    /*feedback*/
    Route::post('/feedback', [ 'as' => 'feedback', 'uses' => 'FeedbackController@index']);


   /*service-history*/
    Route::get('/service-history', [ 'as' => 'service-history', 'uses' => 'ServiceHistoryController@index']);

  /*notification-history*/

    Route::get('/notification/history', [ 'as' => 'notification.history', 'uses' => 'NotificationHistoryController@index']);
});









