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

});
