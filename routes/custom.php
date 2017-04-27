<?php
/**
 * Created by PhpStorm.
 * User: USER001
 * Date: 4/27/2017
 * Time: 12:46 PM
 */

Route::get('test', function () {
    return 'Sheba Tech';
});


Route::group(['prefix' => 'admin', 'namespace' => 'V1'], function()
{

    Route::any('/service', [ 'as' => 'service', 'uses' => 'UMController@index']);

});






