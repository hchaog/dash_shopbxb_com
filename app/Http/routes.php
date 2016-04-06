<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group(['middleware' => 'web'], function () {
    Route::auth();
	Route::get('/', function () {
	    return view('welcome');
	});
    Route::get('/home', 'HomeController@index');
    Route::get('/inventory', 'HomeController@inventoryFilePage'); 
    Route::get('/product', 'HomeController@productInfoPage'); 
    Route::get('/shipment', 'HomeController@shipmentStatusPage');
    Route::post('/inventoryDownloadPostHandler', 'FormHandlerController@inventoryDownloadPostHandler');
    Route::post('/productInformationPostRequest', 'FormHandlerController@productInformationPostRequest');
    Route::post('/shipmentInformationPostRequest', 'FormHandlerController@shipmentInformationPostRequest'); 
});
