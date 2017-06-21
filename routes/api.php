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




    //Route::post('/register', 'Api\V1\LoginController@register');
    //Route::post('/login', 'Api\V1\LoginController@login');

/*Route::post('/api/login', 'Api\V1\LoginController@login')->middleware('auth.basic');*/

Route::post('/api/register', 'Api\V1\LoginController@register');

Route::group(['prefix'=>'api','namespace' => 'Api\V1', 'middleware' => 'auth.basic' ], function () {

    /*Route::get('auth', function (Request $request) {
        //return $request->user();
        return response()->json(['name'=>$request->user()->name,
            'email'=>$request->user()->email,
            'provider'=>$request->user()->provider,
            'provider_id'=>$request->user()->provider_id,
            ]);

    });*/

    /*basic :auth */

//    Route::post('/register', 'LoginController@register');
    Route::post('/login', 'LoginController@login');

    Route::post('/logout', 'LoginController@logout');


    /*Services....... */

    Route::get('/service-center', [ 'as' => 'service-center', 'uses' => 'ServiceCenterController@index']);

    Route::get('/service-package', [ 'as' => 'service-package', 'uses' => 'ServicePackageController@index']);

    Route::post('/service-request', [ 'as' => 'service-request', 'uses' => 'ServiceRequestController@store']);

    Route::post('/min-distance',[ 'as' => 'min-distance', 'uses' => 'ServiceCenterController@distanceCalculation']);


    /*Faqs*/
    Route::get('/faqs', [ 'as' => 'service-request', 'uses' => 'FaqController@index']);

    Route::post('/faq-store', [ 'as' => 'service-request', 'uses' => 'FaqController@store']);


    /*Vehicle*/
    Route::post('/vehicle', [ 'as' => 'vehicle', 'uses' => 'VehicleController@index']);

    Route::post('/vc-store', [ 'as' => 'vc-store', 'uses' => 'VehicleCatalogController@store']);

    Route::post('/vehicle-catalog', [ 'as' => 'vehicle-catalog', 'uses' => 'VehicleCatalogController@index']);


    /*E Doc Type*/
    Route::post('/doc-type-store', [ 'as' => 'doc-type-store', 'uses' => 'EDocTypeController@store']);


    /*E Document*/
    Route::post('/docs-store', [ 'as' => 'docs-store', 'uses' => 'EDocumentController@store']);

    Route::post('/docs', [ 'as' => 'docs', 'uses' => 'EDocumentController@index']);



    /* promotions*/
    Route::get('/promotion', [ 'as' => 'promotion', 'uses' => 'PromotionController@index']);

    Route::post('/promotion-store', [ 'as' => 'promotion-store', 'uses' => 'PromotionController@store']);


    /*Brochure*/
    Route::get('/brochure', [ 'as' => 'brochure', 'uses' => 'BrochureController@index']);

    Route::post('/brochure-store', [ 'as' => 'brochure-store', 'uses' => 'BrochureController@store']);


    /*news & events..*/
    Route::get('/news-events', [ 'as' => 'news-events', 'uses' => 'NewsEventsController@index']);

    Route::post('/store-news-events', [ 'as' => 'store-news-events', 'uses' => 'NewsEventsController@store']);


    /*test*/
    Route::get('/geocode', [ 'as' => 'service-request', 'uses' => 'FaqController@geocode']);

});









