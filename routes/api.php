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

Route::prefix('v1')->middleware('auth:api')->group(function () {
    Route::resource('templates', 'TemplatesController');
    Route::resource('labels', 'LabelsController');
    Route::apiResource('types', 'TypesController', ['only' => ['index']]);
    Route::get('permission-groups', 'PermissionGroupsController@index');
    Route::apiResource('roles', 'RolesController');

    Route::get('templates/{templateId}/attributes', 'TemplatesController@attributes');

    // Attributes
    Route::get('attributes/{attributeId}', 'AttributesController@show');
    Route::post('attributes', 'AttributesController@store');
    Route::match(['PUT', 'PATCH'], 'attributes/{attributeId}', 'AttributesController@update');
    Route::delete('attributes/{attributeId}', 'AttributesController@destroy');

    Route::apiResource('users', 'UsersController');
    Route::get('logs', 'LogsController@index');

    //Documents, Order is important (patch overrides apiResource)
    Route::patch('documents/{id}', 'DocumentsController@patchUpdate');
    Route::put('documents/{id}', 'DocumentsController@update');
    Route::apiResource('documents', 'DocumentsController');
    Route::delete('documents', 'DocumentsController@bulkDestroy');
    Route::patch('documents', 'DocumentsController@bulkPatchUpdate');
    Route::get('documents/{documentId}/versions', 'DocumentsController@versions');

    // Document versions
    Route::get('document-versions/{documentVersionId}', 'DocumentVersionsController@show');
    Route::post('document-versions', 'DocumentVersionsController@store');
    Route::match(['PUT', 'PATCH'], 'document-versions/{documentVersionId}', 'DocumentVersionsController@update');
    Route::delete('document-versions/{documentVersionId}', 'DocumentVersionsController@destroy');


    Route::post('files', 'FileController@uploadFile');

    Route::post('oauth/logout', 'Auth\LoginController@logout');
});
