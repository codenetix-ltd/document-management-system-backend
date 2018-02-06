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

Route::prefix('v1')->group(function () {
    Route::apiResource('users', 'API\UserController');

    Route::apiResource('templates', 'API\TemplateController');

    Route::apiResource('tags', 'API\TagController');

    Route::apiResource('types', 'API\TypeController', ['only' => ['index']]);

    Route::post('templates/{templateId}/attributes', 'API\AttributeController@store');
});