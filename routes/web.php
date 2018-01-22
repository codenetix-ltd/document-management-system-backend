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
use App\Document;
use App\DocumentVersion;
use App\Type;

Auth::routes();

Route::group(['middleware' => ['auth', 'roles']], function () {
    Route::get('/', function () {
        return redirect(route('documents.list'));
    })->name('home');

    Route::post('/document-attachments', ['uses' => 'DocumentAttachmentsController@store', 'as' => 'document_attachments.store']);
    Route::delete('/document-attachments/{id}', ['uses' => 'DocumentAttachmentsController@delete', 'as' => 'document_attachments.delete']);

    Route::get('/partials/type-form', ['uses' => 'TemplateAttributesController@typeForm', 'as' => 'partials_type_form.get']);

    Route::get('/attributes/list', ['uses' => 'DocumentsController@listAttributes', 'as' => 'attributes.list']);
    Route::get('/attributes/{id}/delete', ['uses' => 'TemplateAttributesController@delete', 'as' => 'attributes.delete']);

    Route::get('/document_versions/{id}', ['uses' => 'DocumentsController@getDocumentVersion', 'as' => 'document_versions.get']);
    Route::get('/document_versions/{id}/delete', ['uses' => 'DocumentsController@deleteDocumentVersion', 'as' => 'document_versions.delete']);

    Route::get('/documents/{id}/files/list', ['uses' => 'DocumentsController@listFiles', 'as' => 'document_files.list']);
    Route::get('/documents/list', ['uses' => 'DocumentsController@index', 'as' => 'documents.list']);
    Route::get('/documents', ['uses' => 'DocumentsController@create', 'as' => 'documents.create']);
    Route::get('/documents/{id}', ['uses' => 'DocumentsController@edit', 'as' => 'documents.edit']);
    Route::post('/documents', ['uses' => 'DocumentsController@store', 'as' => 'documents.store']);
    Route::post('/documents/{id}', ['uses' => 'DocumentsController@update', 'as' => 'documents.update']);
    Route::get('/documents/{id}/delete', ['uses' => 'DocumentsController@delete', 'as' => 'documents.delete']);
    Route::get('/documents/view/{id}', ['uses' => 'DocumentsController@view', 'as' => 'documents.view']);

    Route::group([], function () {
        Route::get('/templates/list', ['uses' => 'TemplatesController@index', 'as' => 'templates.list']);
        Route::get('/templates', ['uses' => 'TemplatesController@create', 'as' => 'templates.create']);
        Route::get('/templates/{id}', ['uses' => 'TemplatesController@edit', 'as' => 'templates.edit']);
        Route::post('/templates/{id}', ['uses' => 'TemplatesController@update', 'as' => 'templates.update']);
        Route::get('/templates/{id}/delete', ['uses' => 'TemplatesController@delete', 'as' => 'templates.delete']);

        Route::post('/templates', ['uses' => 'TemplatesController@store', 'as' => 'templates.store']);

        Route::get('/templates/{templateId}/attributes', ['uses' => 'TemplateAttributesController@create', 'as' => 'template_attributes.create']);
        Route::get('/templates/{templateId}/attributes/{id}', ['uses' => 'TemplateAttributesController@edit', 'as' => 'template_attributes.edit']);
        Route::post('/templates/{templateId}/attributes/{id}', ['uses' => 'TemplateAttributesController@update', 'as' => 'template_attributes.update']);
        Route::post('/templates/{templateId}/attributes', ['uses' => 'TemplateAttributesController@store', 'as' => 'template_attributes.store']);

        Route::get('/users/add', ['uses' => function () {
            return view('pages.users.add_edit');
        }, 'as' => 'users.create']);

        Route::get('/users/list', ['uses' => 'UsersController@index', 'as' => 'users.list', 'role' => 'Admin']);
        Route::get('/users/{id}', ['uses' => 'UsersController@edit', 'as' => 'users.edit']);
        Route::get('/users', ['uses' => 'UsersController@create', 'as' => 'users.create']);
        Route::post('/users/{id}', ['uses' => 'UsersController@update', 'as' => 'users.update']);
        Route::post('/users', ['uses' => 'UsersController@store', 'as' => 'users.store']);
        Route::get('/users/delete/{id}', ['uses' => 'UsersController@delete', 'as' => 'users.delete']);

        Route::get('/logs/list', ['uses' => 'LogsController@index', 'as' => 'logs.list']);

        Route::get('/labels/list', ['uses' => 'LabelsController@index', 'as' => 'labels.list']);
        Route::get('/labels', ['uses' => 'LabelsController@create', 'as' => 'labels.create']);
        Route::post('/labels', ['uses' => 'LabelsController@store', 'as' => 'labels.store']);
        Route::get('/labels/{id}', ['uses' => 'LabelsController@edit', 'as' => 'labels.edit']);
        Route::post('/labels/{id}', ['uses' => 'LabelsController@update', 'as' => 'labels.update']);
        Route::get('/labels/{id}/delete', ['uses' => 'LabelsController@delete', 'as' => 'labels.delete']);



        Route::get('/roles/list', ['uses' => 'RolesController@index', 'as' => 'roles.list']);
        Route::get('/roles', ['uses' => 'RolesController@create', 'as' => 'roles.create']);
        Route::post('/roles', ['uses' => 'RolesController@store', 'as' => 'roles.store']);
        Route::get('/roles/{id}', ['uses' => 'RolesController@edit', 'as' => 'roles.edit']);
        Route::post('/roles/{id}', ['uses' => 'RolesController@update', 'as' => 'roles.update']);
        Route::get('/roles/{id}/delete', ['uses' => 'RolesController@delete', 'as' => 'roles.delete']);
        Route::get('/roles/{id}/permissions', ['uses' => 'RolesController@getPermissionsList', 'as' => 'roles.permissions']);


        Route::get('/permissions/template/{permission}', ['uses' => 'PermissionController@getTemplateByPermission', 'as' => 'permissions.template']);
        Route::post('/roles/{id}/permissions', ['uses' => 'RolesController@postAssignPermission', 'as' => 'roles.assign_permission']);
        Route::get('/roles/{id}/detach-permission/{relationId}', ['uses' => 'RolesController@getDetachPermission', 'as' => 'roles.detach_permission']);
    });

    Route::prefix('api')->group(function () {
        Route::get('/permissions/{id}/level-form', ['uses' => 'API\PermissionController@getLevels', 'as' => 'api.permissions.level_form']);
        Route::get('/documents', ['uses' => 'API\DocumentController@getList', 'as' => 'api.documents.list']);
        Route::post('/documents-archive', ['uses' => 'API\DocumentController@massArchive', 'as' => 'api.documents.mass_archive']);
        Route::post('/documents-delete', ['uses' => 'API\DocumentController@massDelete', 'as' => 'api.documents.mass_delete']);
        Route::post('/documents/{id}/export', ['uses' => 'API\DocumentController@exportDocument', 'as' => 'documents.export']);
        Route::get('/attribute-values', ['uses' => 'API\DocumentController@getDocumentAttributeValues', 'as' => 'api.attribute_values.values']);

        Route::get('/factories', ['uses' => 'API\FactoryController@getList', 'as' => 'api.factories.list']);
        Route::get('/templates', ['uses' => 'API\TemplateController@getList', 'as' => 'api.templates.list']);
        Route::get('/users', ['uses' => 'API\UserController@getList', 'as' => 'api.users.list']);
    });

    Route::get('/profile/{id}', ['uses' => 'UsersController@editProfile', 'as' => 'profile.edit']);
    Route::post('/profile/{id}', ['uses' => 'UsersController@updateProfile', 'as' => 'profile.update']);

    //extra
    Route::get('/filter', function () {
        $documents = Document::paginate(15);
        return view('pages.extra.filter', compact('documents'));
    })->name('filter');

    Route::get('/export', function () {
        return view('pages.extra.export');
    })->name('filter');

    Route::get('/compare', ['uses' => 'DocumentsController@compare', 'as' => 'documents.compare']);
});

