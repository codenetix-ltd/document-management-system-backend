<?php
namespace App\Builders\ParameterBuilders;

use App\Contracts\Builders\IDocumentParameterCollectionBuilder;
use App\Entity\Document;
use App\Entity\Parameters\BooleanParameter;
use App\Entity\Parameters\CollectionParameter;
use App\Entity\Parameters\FileParameter;
use App\Entity\Parameters\ParametersCollection;
use App\Entity\Parameters\StringParameter;
use App\Entity\Parameters\Table;
use App\Entity\Parameters\TableParameter;
use App\Entity\Parameters\TableRow;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentViewParameterCollectionBuilder extends BaseDocumentParameterCollectionBuilder
{
    protected function defineAllowedParameterKeys()
    {
        $this->allowedKeys = $this->allowedKeys->merge([
            'name',
            'version_name',
            'owner_name',
            'template_name',
            'factories_name_list',
            'labels_name_list',
            'files',
            'comment',
            'created_at'
        ]);
    }
}