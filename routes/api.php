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
Route::post('apilogin', 'Api\LoginController@index');
Route::get('capaian', 'Api\GetadataController@capaian');
Route::get('kpi', 'Api\GetadataController@kpi');
Route::get('unit', 'Api\GetadataController@unit');
// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
