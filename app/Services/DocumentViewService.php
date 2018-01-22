<?php

namespace App\Services;

use App\Builders\AttributeStructureBuilders\DocumentCompareStructureBuilder;
use App\Commands\Attributes\AttributesStructureByTemplateIdGetCommand;
use App\Commands\Document\DocumentGetCommand;
use App\Commands\Document\DocumentGroupsListCommand;
use App\Contracts\Builders\IDocumentParameterCollectionBuilder;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use App\Entity\Attributes\AttributesCollection;
use App\Exceptions\CommandException;
use Exception;
use Illuminate\Contracts\Container\Container;

class DocumentViewService extends ADocumentViewService
{

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $documentGetCommand = new DocumentGetCommand($this->container, $this->getDocumentId(), $this);
        $documentGetCommand->execute();

        $attributesSetValuesByDocumentVersionIdCommand = new AttributesStructureByTemplateIdGetCommand($this->container, $this->getDocument(), $this->getDocument()->getTemplateModel()->id, $this->documentVersionId ? $this->documentVersionId : $this->getDocument()->getDocumentVersionModel()->id);
        $attributesSetValuesByDocumentVersionIdCommand->execute();

        if($this->parameterBuilder){
            $this->parameterBuilder->setDocument($this->getDocument());
            $this->getDocument()->setParameters($this->parameterBuilder->build());
        }
    }

}