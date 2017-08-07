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


    //Route::get('/activate', 'ActivateController@activate')->name('auth.activation');

    Route::get('/activate/{token}', 'ActivateController@activate')->name('auth.activation');


    //Route::get('register', 'RegisterController@showRegistrationForm');
    //Route::post('register', 'RegisterController@register');

    /*Route::get('auth/{provider}', 'LoginController@provider');
    Route::get('auth/{provider}/callback', 'LoginController@providerCallback');*/

});


Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');


Route::group(['prefix' => 'admin', 'namespace' => 'Admin','middleware'=>'auth'], function()
{
    /* Permission */

    Route::get('/permission',
        ['as' => 'admin.permission.index', 'uses' => 'PermissionController@index', 'middleware' => ['role:super-administrator|administrator|manager']
    ]);

    Route::get('/permission/create',
        ['as'=>'permission-create','uses' => 'PermissionController@create', 'middleware' => ['role:super-administrator']]);

    Route::post('/permission/store',
        ['as' => 'permission-store','uses' => 'PermissionController@store', 'middleware' => ['role:super-administrator']]);


    Route::get('/permission/{id}', [
        'as' => 'admin.permission.show', 'uses' => 'PermissionController@show', 'middleware' => ['role:super-administrator|administrator|manager']
    ]);

    Route::get('/permission/{id}/edit', [ 'as' => 'permission-edit', 'uses' => 'PermissionController@edit', 'middleware' => ['role:super-administrator']]);

    Route::put('/permission/{id}/update', [ 'as' => 'permission-update', 'uses' => 'PermissionController@update', 'middleware' => ['role:super-administrator']]);


    Route::match(['get', 'post'], 'permission', ['uses' => 'PermissionController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::get('/permission/{id}/delete', [ 'as' => 'permission-delete', 'uses' => 'PermissionController@delete', 'middleware' => ['role:super-administrator']]);


    /*Role*/
    Route::get('/role',
        ['as' => 'admin.role.index', 'uses' => 'RoleController@index', 'middleware' => ['role:super-administrator|administrator|manager']
        ]);

    Route::get('/role/create',
        ['as'=>'role-create','uses' => 'RoleController@create', 'middleware' => ['role:super-administrator']]);

    Route::post('/role/store',
        ['as' => 'role-store','uses' => 'RoleController@store', 'middleware' => ['role:super-administrator']]);

    Route::get('/role/{id}', [
        'as' => 'admin.role.show', 'uses' => 'RoleController@show', 'middleware' => ['role:super-administrator|administrator|manager']
    ]);

    Route::get('/role/{id}/edit', [ 'as' => 'role-edit', 'uses' => 'RoleController@edit', 'middleware' => ['role:super-administrator']]);

    Route::put('/role/{id}/update', [ 'as' => 'role-update', 'uses' => 'RoleController@update', 'middleware' => ['role:super-administrator']]);


    Route::any('/role/delete/{id}', [ 'as' => 'role-delete', 'uses' => 'RoleController@delete', 'middleware' => ['role:super-administrator']]);

    Route::match(['get', 'post'], 'role', ['uses' => 'RoleController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);




    /*User*/
    //Route::resource('/user', 'UserController', [ 'except' => ['index'] , 'middleware' => ['role:super-administrator']]);

    Route::get('/user',
        ['as' => 'admin.user.index', 'uses' => 'UserController@index', 'middleware' => ['role:super-administrator|administrator|manager']
        ]);

    Route::get('/user/create',
        ['as'=>'user-create','uses' => 'UserController@create', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/user/store',
        ['as' => 'user-store','uses' => 'UserController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::get('/user/{id}', [
        'as' => 'admin.user.show', 'uses' => 'UserController@show', 'middleware' => ['role:super-administrator|administrator|manager']
    ]);

    Route::get('/user/{id}/edit', [ 'as' => 'user-edit', 'uses' => 'UserController@edit', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::put('/user/{id}/update', [ 'as' => 'user-update', 'uses' => 'UserController@update', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::any('/user/delete/{id}', [ 'as' => 'user-delete', 'uses' => 'UserController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'user', ['uses' => 'UserController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);




    /*service-location*/
    Route::resource('/service-center',  'ServiceCenterController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'service-center', ['uses' => 'ServiceCenterController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/service-center/store', ['as' => 'service-center','uses' => 'ServiceCenterController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/service-center/delete/{id}', [ 'as' => 'service-center-delete', 'uses' => 'ServiceCenterController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*service-package*/

    Route::resource('/service-package',  'ServicePackageController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'service-package', ['uses' => 'ServicePackageController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/service-package/store', ['as' => 'service-package','uses' => 'ServicePackageController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/service-package/delete/{id}', [ 'as' => 'service-package-delete', 'uses' => 'ServicePackageController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*service-package-type*/
    Route::resource('/service-package-type',  'ServicePackageTypeController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'service-package-type', ['uses' => 'ServicePackageTypeController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/service-package-type/store', ['as' => 'service-package-type-store','uses' => 'ServicePackageTypeController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/service-package-type/delete/{id}', [ 'as' => 'service-package-type-delete', 'uses' => 'ServicePackageTypeController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);



    /*vehicle-type*/
    Route::resource('/vehicle-type',  'VehicleTypeController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'vehicle-type', ['uses' => 'VehicleTypeController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/vehicle-type/store', ['as' => 'vehicle-type','uses' => 'VehicleTypeController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/vehicle-type/delete/{id}', [ 'as' => 'vehicle-type-delete', 'uses' => 'VehicleTypeController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Vehicle Model*/
    Route::resource('/vehicle-model',  'VehicleModelController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'vehicle-model', ['uses' => 'VehicleModelController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/vehicle-model/store', ['as' => 'vehicle-model','uses' => 'VehicleModelController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/vehicle-model/delete/{id}', [ 'as' => 'vehicle-model-delete', 'uses' => 'VehicleModelController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Vehicle*/

    Route::resource('/vehicle',  'VehicleController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'vehicle', ['uses' => 'VehicleController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/vehicle/store', ['as' => 'vehicle','uses' => 'VehicleController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/vehicle/delete/{id}', [ 'as' => 'vehicle-delete', 'uses' => 'VehicleController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/vehicle-image/{id}', [ 'as' => 'vehicle-image', 'uses' => 'VehicleController@vehicle_image', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::any('/vehicle-colors/{id}', [ 'as' => 'vehicle-colors', 'uses' => 'VehicleController@vehicle_colors', 'middleware' => ['role:super-administrator|administrator|manager']]);

    /*Vehicle brands*/

    Route::resource('/brand',  'BrandController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'brand', ['uses' => 'BrandController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/brand/store', ['as' => 'brand','uses' => 'BrandController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/brand/delete/{id}', [ 'as' => 'brand-delete', 'uses' => 'BrandController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


   /*spare parts category*/

   /* Route::resource('/spare-parts-category',  'SparePartsCategoryController');

    Route::any('/spare-parts-category/delete/{id}', [ 'as' => 'spare-parts-category-delete', 'uses' => 'SparePartsCategoryController@delete']);*/


    /*Spare parts*/

    Route::resource('/spare-parts',  'SparePartsController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'spare-parts', ['uses' => 'SparePartsController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/spare-parts/store', ['as' => 'spare-parts','uses' => 'SparePartsController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/spare-parts/delete/{id}', [ 'as' => 'spare-parts-delete', 'uses' => 'SparePartsController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Brochure*/

    Route::resource('/brochure',  'BrochureController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'brochure', ['uses' => 'BrochureController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/brochure/store', ['as' => 'brochure','uses' => 'BrochureController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/brochure/delete/{id}', [ 'as' => 'brochure-delete', 'uses' => 'BrochureController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*EDoc Type*/

    Route::resource('/e-doc-type',  'EDocTypeController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'e-doc-type', ['uses' => 'EDocTypeController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/e-doc-type/store', ['as' => 'e-doc-type','uses' => 'EDocTypeController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/e-doc-type/delete/{id}', [ 'as' => 'e-doc-type-delete', 'uses' => 'EDocTypeController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

    /*E Documents*/

    Route::resource('/e-documents',  'EDocumentController',['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'e-documents', ['uses' => 'EDocumentController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/e-documents/store', ['as' => 'e-documents','uses' => 'EDocumentController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/e-documents/delete/{id}', [ 'as' => 'e-documents-delete', 'uses' => 'EDocumentController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Faq*/

    Route::resource('/faq',  'FaqController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'faq', ['uses' => 'FaqController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/faq/store', ['as' => 'faq','uses' => 'FaqController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/faq/delete/{id}', [ 'as' => 'faq-delete', 'uses' => 'FaqController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

   /*News Events*/

    Route::resource('/news-events',  'NewsEventsController',
        ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'news-events', ['uses' => 'NewsEventsController@index',
        'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/news-events/store', ['as' => 'news-events','uses' => 'NewsEventsController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/news-events/delete/{id}', [ 'as' => 'news-events-delete', 'uses' => 'NewsEventsController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Promotions*/
    Route::resource('/promotions',  'PromotionController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'promotions', ['uses' => 'PromotionController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/promotions/store', ['as' => 'promotions','uses' => 'PromotionController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/promotions/delete/{id}', [ 'as' => 'promotions-delete', 'uses' => 'PromotionController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*Service History*/

    Route::resource('/service-history',  'ServiceHistoryController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'service-history', ['uses' => 'ServiceHistoryController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    /*feedback*/
    Route::resource('/feedback',  'FeedbackController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'feedback', ['uses' => 'FeedbackController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/feedback/delete/{id}', [ 'as' => 'feedback-delete', 'uses' => 'FeedbackController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/feedback/reply/{id}', [ 'as' => 'reply-feedback', 'uses' => 'FeedbackController@reply', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/feedback/store-reply/{id}', [ 'as' => 'store-reply', 'uses' => 'FeedbackController@store_reply', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*service_request*/

    Route::resource('/service-request', 'ServiceRequestController', ['except' => ['index'], 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'service-request', ['uses' => 'ServiceRequestController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    /*notification*/

    Route::get('/notification', ['as' => 'notification','uses' => 'PushNotificationController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);


    /*user-vehicle*/

    Route::get('/user-vehicle',
        ['as' => 'user-vehicle', 'uses' => 'UserVehicleController@index', 'middleware' => ['role:super-administrator|administrator|manager']
        ]);

    Route::get('/user-vehicle/create',
        ['as'=>'user-vehicle-create','uses' => 'UserVehicleController@create', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/user-vehicle/store',
        ['as' => 'user-vehicle-store','uses' => 'UserVehicleController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/user-vehicle/{id}/view', [ 'as' => 'user-vehicle.view', 'uses' => 'UserVehicleController@view', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::any('/user-vehicle/{id}/edit', [ 'as' => 'user-vehicle.edit', 'uses' => 'UserVehicleController@edit', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/user-vehicle/{id}/update', [ 'as' => 'user-vehicle.update', 'uses' => 'UserVehicleController@update', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::any('/user-vehicle/{id}/delete', [ 'as' => 'user-vehicle.delete', 'uses' => 'UserVehicleController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::match(['get', 'post'], 'user-vehicle', ['uses' => 'UserVehicleController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::get('/user-vehicle/vehicle/{typeid}/{modelid}', 'UserVehicleController@vehicle');




    /*employee*/

    Route::get('/employee',
        ['as' => 'admin.employee.index', 'uses' => 'EmployeeController@index', 'middleware' => ['role:super-administrator|administrator|manager']
        ]);

    Route::get('/employee/create',
        ['as'=>'employee-create','uses' => 'EmployeeController@create', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::post('/employee/store',
        ['as' => 'employee-store','uses' => 'EmployeeController@store', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::get('/employee/{id}', [
        'as' => 'admin.employee.show', 'uses' => 'EmployeeController@show', 'middleware' => ['role:super-administrator|administrator|manager']
    ]);

    Route::get('/employee/{id}/edit', [ 'as' => 'employee-edit', 'uses' => 'EmployeeController@edit', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::put('/employee/{id}/update', [ 'as' => 'employee-update', 'uses' => 'EmployeeController@update', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::match(['get', 'post'], 'employee', ['uses' => 'EmployeeController@index', 'middleware' => ['role:super-administrator|administrator|manager']]);

    Route::get('/employee/{id}/delete', [ 'as' => 'employee-delete', 'uses' => 'EmployeeController@delete', 'middleware' => ['role:super-administrator|administrator|manager']]);




    Route::get('/employee-assign/{id}/create',
        ['as'=>'employee-assign-create','uses' => 'ServiceRequestController@create', 'middleware' => ['role:super-administrator|administrator|manager']]);


    Route::put('/employee/{id}/assign',
        ['as' => 'employee-assign','uses' => 'ServiceRequestController@assign', 'middleware' => ['role:super-administrator|administrator|manager']]);





});


Route::get('test', [ 'as' => 'test', 'uses' => 'TestController@index']);


/*------test------*/




