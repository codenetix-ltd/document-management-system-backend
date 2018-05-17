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

    //Order is important (patch overrides apiResource)
    Route::patch('documents/{id}', 'API\DocumentController@patchUpdate');
    Route::put('documents/{id}', 'API\DocumentController@update');
    Route::apiResource('documents', 'API\DocumentController');

    Route::delete('documents', 'API\DocumentController@bulkDestroy');
    Route::patch('documents', 'API\DocumentController@bulkPatchUpdate');



    Route::get('documents/{id}/versions', 'API\DocumentVersionController@index');
    Route::put('documents/{id}/actualVersion', 'API\DocumentController@setActualVersion');
    Route::get('documents/{id}/versions/{versionId}', 'API\DocumentVersionController@show');
    Route::delete('documents/{id}/versions/{versionId}', 'API\DocumentVersionController@destroy');
    Route::get('logs', 'Api\LogController@index');

    Route::post('files', 'FileController@uploadFile');
});

Route::resource('templates', 'TemplatesController');
Route::resource('labels', 'LabelsController');
Route::apiResource('types', 'TypesController', ['only' => ['index']]);
Route::get('permission-groups', 'PermissionGroupsController@index');
Route::apiResource('roles', 'RolesController');

Route::post('templates/{templateId}/attributes', 'AttributesController@store');
Route::get('attributes/{id}', 'AttributesController@show');
Route::delete('attributes/{id}', 'AttributesController@destroy');
Route::get('templates/{id}/attributes', 'AttributesController@index');

