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
class BaseDocumentParameterCollectionBuilder extends BaseParameterCollectionBuilder implements IDocumentParameterCollectionBuilder
{

    private $document;

    /**
     * @return mixed
     */
    public function getDocument(): Document
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument(Document $document): void
    {
        $this->document = $document;
    }

    protected function defineParameterBuilders()
    {
        $this->parameterBuilders->put('name', function () {
            return new StringParameter('name', $this->document->getName());
        });
        $this->parameterBuilders->put('owner_name', function () {
            return new StringParameter('owner_name', $this->document->getUserModel()->full_name);
        });
        $this->parameterBuilders->put('template_name', function () {
            return new StringParameter('template_name', $this->document->getTemplateModel()->name);
        });
        $this->parameterBuilders->put('factories_name_list', function () {
            return new CollectionParameter('factories_name_list', $this->document->getFactoryModels()->map(function ($item) {
                return new StringParameter($item->id, $item->name);
            }));
        });
        $this->parameterBuilders->put('labels_name_list', function () {
            return new CollectionParameter('labels_name_list', $this->document->getLabelModels()->map(function ($item) {
                return new StringParameter($item->id, $item->name);
            }));
        });
        $this->parameterBuilders->put('is_actual_version', function () {
            return new BooleanParameter('is_actual_version', $this->document->getDocumentVersionModel()->is_actual);
        });

        $this->parameterBuilders->put('version_name', function () {
            return new StringParameter('version_name', $this->document->getDocumentVersionModel()->version_name);
        });

        $this->parameterBuilders->put('files', function () {
            $filesTable = new Table();
            $this->document->getDocumentVersionModel()->files->each(function ($item) use ($filesTable) {
                $row = new TableRow(basename(asset('storage/' . $item->path)));
                $row->addCell(new FileParameter('', asset('storage/' . $item->path)));
                $filesTable->addRow($row);
            });

            return new TableParameter('files', $filesTable);
        });
        $this->parameterBuilders->put('comment', function () {
            return new StringParameter('comment', $this->document->getDocumentVersionModel()->comment);
        });
        $this->parameterBuilders->put('created_at', function () {
            return new StringParameter('created_at', $this->document->getCreatedAt());
        });
    }

    protected function defineAllowedParameterKeys()
    {
        $this->allowedKeys = $this->allowedKeys->merge([
            'name',
            'version_name',
            'owner_name',
            'template_name',
            'factories_name_list',
            'labels_name_list',
            'is_actual_version',
            'name',
            'files',
            'comment',
            'created_at'
        ]);
    }
}