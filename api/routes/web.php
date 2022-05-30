<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'namespace' => 'App\Http\Controllers',
], function () {
    //Route::get('/', 'SiteController@index');
    Route::get('/', 'SiteController@home');
    Route::get('/home', 'SiteController@home');
    Route::get('/quem-somos', 'SiteController@quemSomos');
    Route::get('/contato', 'SiteController@contato');
    Route::get('/cases', 'SiteController@cases');
    Route::get('/cases/{id}', 'SiteController@caseItem');
    Route::get('/solucoes', 'SiteController@solucoes');
    Route::get('/pagina/{page}', 'SiteController@customPage');
    Route::get('/cms', 'SiteController@cms');
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'prefix' => '/test'
], function () {
    Route::get('/new-contact',  function() {
        return new App\Mail\NewContact(
            App\Models\Contact::factory()->make()
        );
    });
    Route::get('/thanks-contact',  function() {
        return new App\Mail\ThanksContact(
            App\Models\Contact::factory()->make()
        );
    });
    Route::get('/user-email-confirmation',  function() {
        return new App\Mail\UserMailConfirmation(
            App\Models\User::find(1)
        );
    });
});