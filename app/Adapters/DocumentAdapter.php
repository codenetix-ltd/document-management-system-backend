<?php

namespace App\Adapters;

use App\Document as DocumentModel;
use App\Entity\Document;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentAdapter
{
    public function transform(DocumentModel $model)
    {
        $document = new Document();

        $document->setId($model->id);
        $document->setBaseModel($model);
        $document->setName($model->name);
        $document->setUserModel($model->owner);
        $document->setFactoryModels($model->factories);
        $document->setTemplateModel($model->template);
        $document->setDocumentVersionModel($model->documentActualVersion);
        $document->setDocumentVersionModels($model->documentVersions);
        $document->setLabelModels($model->labels);
        $document->setIsTrashed($model->trashed());
        $document->setLabelModels($model->labels);
        $document->setUpdatedAt($model->updated_at);
        $document->setCreatedAt($model->created_at);

        return $document;
    }
}