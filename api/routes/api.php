<?php

use Illuminate\Support\Facades\Route;

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

Route::group([
    'prefix' => '',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::get('/', 'SiteController@indexApi');
});

Route::group([
    'prefix' => 'auth',
    'namespace' => 'App\Http\Controllers',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
});


// Route::group([
//     'prefix' => 'users',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'UserController@store');
//     Route::delete('/', 'UserController@delete');
//     Route::get('/{id}', 'UserController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'UserController@getAll');
//     Route::get('/send-confirm-mail/{id}', 'UserController@sendConfirmMail')->where('id', '[0-9]+');
//     Route::get('/confirm-mail/{id}/{hash}', 'UserController@confirmMail')->where('id', '[0-9]+');
//     Route::get('/permissions', 'UserController@getPermissionsList');
//     Route::post('/permissions', 'UserController@setPermissions');
// });

// Route::group([
//     'prefix' => 'categories',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'CategorieController@store');
//     Route::delete('/', 'CategorieController@delete');
//     Route::get('/{id}', 'CategorieController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'CategorieController@getAll');
// });

// Route::group([
//     'prefix' => 'cases',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'CaseItemController@store');
//     Route::delete('/', 'CaseItemController@delete');
//     Route::get('/{id}', 'CaseItemController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'CaseItemController@getAll');
//     Route::post('/galery', 'CaseItemController@addImageToGalery');
//     Route::delete('/galery', 'CaseItemController@deleteImageFromGalery');
// });

// Route::group([
//     'prefix' => 'solutions',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'SolutionController@store');
//     Route::delete('/', 'SolutionController@delete');
//     Route::get('/{id}', 'SolutionController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'SolutionController@getAll');
// });

// Route::group([
//     'prefix' => 'sliders',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'SliderController@store');
//     Route::delete('/', 'SliderController@delete');
//     Route::get('/{id}', 'SliderController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'SliderController@getAll');
//     Route::get('/broadcasting/{type?}', 'SliderController@broadcasting')->where('type', '[0-9a-z]+');
// });

// Route::group([
//     'prefix' => 'pages',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'PageController@store');
//     Route::delete('/', 'PageController@delete');
//     Route::get('/{id}', 'PageController@getOne')->where('id', '[0-9]+');
//     Route::get('/slug/{slug}', 'PageController@getBySlug');
//     Route::get('/', 'PageController@getAll');
// });

// Route::group([
//     'prefix' => 'contacts',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'ContactController@store');
//     Route::post('/status', 'ContactController@status');
//     Route::post('/column/{name}', 'ContactController@setColumn');
//     Route::delete('/', 'ContactController@delete');
//     Route::get('/{id}', 'ContactController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'ContactController@getAll');
//     Route::get('/email-confirmation/{id}', 'ContactController@confirmEmail')->where('id', '[0-9]+');;
// });

// Route::group([
//     'prefix' => 'notifiables',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'NotifiableController@store');
//     Route::delete('/', 'NotifiableController@delete');
//     Route::get('/{id}', 'NotifiableController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'NotifiableController@getAll');
// });

// Route::group([
//     'prefix' => 'images',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/', 'ImageController@store');
//     Route::delete('/', 'ImageController@delete');
//     Route::get('/{id}', 'ImageController@getOne')->where('id', '[0-9]+');
//     Route::get('/', 'ImageController@getAll');
// });

// Route::group([
//     'prefix' => 'dashboard',
//     'namespace' => 'App\Http\Controllers',
// ], function () {
//     Route::post('/timeline', 'DashboardController@timeline');
//     Route::post('/navegations', 'DashboardController@navegations');
// });
