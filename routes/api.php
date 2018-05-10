<?php

use Illuminate\Http\Request;
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

Route::prefix('v1')->group(function () {
    Route::apiResource('users', 'API\UserController');

    Route::apiResource('templates', 'API\TemplateController');

    Route::apiResource('tags', 'API\TagController');

    Route::apiResource('types', 'API\TypeController', ['only' => ['index']]);

    //Order is important (patch overrides apiResource)
    Route::patch('documents/{id}', 'API\DocumentController@patchUpdate');
    Route::put('documents/{id}', 'API\DocumentController@update');
    Route::apiResource('documents', 'API\DocumentController');

    Route::delete('documents', 'API\DocumentController@bulkDestroy');

    Route::post('templates/{templateId}/attributes', 'API\AttributeController@store');
    Route::get('attributes/{id}', 'API\AttributeController@show');
    Route::delete('attributes/{id}', 'API\AttributeController@destroy');
    Route::get('templates/{id}/attributes', 'API\AttributeController@index');

    Route::get('documents/{id}/versions', 'API\DocumentVersionController@index');
    Route::put('documents/{id}/actualVersion', 'API\DocumentController@setActualVersion');
    Route::get('documents/{id}/versions/{versionId}', 'API\DocumentVersionController@show');
    Route::delete('documents/{id}/versions/{versionId}', 'API\DocumentVersionController@destroy');
    Route::get('logs', 'Api\LogController@index');

    Route::post('files', 'FileController@uploadFile');
});

