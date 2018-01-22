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

class AttributesGetService extends AAttributesGetService
{

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $attributesSetValuesByDocumentVersionIdCommand = new AttributesStructureByTemplateIdGetCommand($this->container, $this, $this->getTemplateId(), $this->getDocumentVersionId());
        $attributesSetValuesByDocumentVersionIdCommand->execute();
    }

}