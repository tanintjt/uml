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


/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/




/*Route::group(['prefix'=>'v1','namespace' => 'V1'], function () {

    Route::get('get-login',['as' =>'get-login', 'uses'=>'UserLoginController@index']);

});*/


//Route::group(['prefix'=>'v1','namespace' => 'V1','middleware' => 'auth.basic'], function () {
//
//
//    Route::get('abc', function (Request $request) {
//        //return $request->user();
//        return response()->json(['name'=>$request->user()->name,
//            'email'=>$request->user()->email,
//            'provider'=>$request->user()->provider]);
//
//    });
//
//    Route::post('post-login', [ 'as' => 'post-user-login', 'uses' => 'UserLoginController@login']);
//
//    //Route::match(array('GET', 'POST'), 'login', 'UserLoginController@login');
//
//    Route::post('user-logout',['as'=>'user-logout', 'uses'=>'UserLoginController@logout']);
//
//});



Route::group(['prefix'=>'api','namespace' => 'Api\V1','middleware' => 'auth.basic'], function () {

    /*Route::get('auth', function (Request $request) {
        //return $request->user();
        return response()->json(['name'=>$request->user()->name,
            'email'=>$request->user()->email,
            'provider'=>$request->user()->provider,
            'provider_id'=>$request->user()->provider_id,
            ]);

    });*/



    Route::post('/login', 'LoginController@login');

    Route::post('/register', 'LoginController@register');

    Route::post('/abc', 'LoginController@logout');


});











