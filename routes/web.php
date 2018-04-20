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

Route::get('/master/changelang',[
    'uses' => 'Pages\masterController@changelang',
    'as' => 'changelang'
]);

Route::get('/', function () {
    return redirect()->route('index');
});

Route::get('/contact', [
    'uses' =>'Pages\ContactController@index',
    'as' => 'contact'
]);

Route::get('/index',[
    'uses' => 'Pages\IndexController@index',
    'as' => 'index'
]);

Route::get('/privacypolicy', [
    'uses' =>'Pages\PrivacyPolicyController@index',
    'as' => 'privacypolicy'
]);

Route::post('/master/webpagetextFromDB', 'Pages\MasterController@webpagetextFromDB');
Route::post('/contact/submitForm', 'Pages\ContactController@submitForm');

Route::get('/{url}', 'Errors\Error404Controller@index');