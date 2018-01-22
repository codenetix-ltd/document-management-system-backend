<?php

namespace App\Services;

use App\Builders\AttributeStructureBuilders\DocumentCompareStructureBuilder;
use App\Commands\Attributes\AttributesStructureByTemplateIdGetCommand;
use App\Commands\Document\DocumentGetCommand;
use App\Commands\Document\DocumentGroupsListCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use App\Entity\Attributes\AttributesCollection;
use App\Exceptions\CommandException;
use Exception;
use Illuminate\Contracts\Container\Container;

class DocumentEditService extends ADocumentEditService
{

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $documentGetCommand = new DocumentGetCommand($this->container, $this->getDocumentId(), $this);
        $documentGetCommand->execute();

        $attributesSetValuesByDocumentVersionIdCommand = new AttributesStructureByTemplateIdGetCommand($this->container, $this->getDocument(), $this->getDocument()->getTemplate()->id, $this->getDocument()->getActualVersionId());
        $attributesSetValuesByDocumentVersionIdCommand->execute();
    }

}