<?php

namespace App\Services;

use App\Builders\AttributeStructureBuilders\DocumentCompareStructureBuilder;
use App\Commands\Attributes\AttributesStructureByTemplateIdGetCommand;
use App\Commands\Document\DocumentGroupsListCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Exceptions\CommandException;
use Exception;

class DocumentCompareService extends ADocumentCompareService
{

    private $documentCompareStructure;

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        //1. Detect groups, count documents in per group
        $documentGroupsListCommand = new DocumentGroupsListCommand($this->container, $this, $this->documentIds);
        $documentGroupsListCommand->execute();

        //2. Get destination group and retrieve all documents from there
        $destinationGroup = $this->retrieveDestinationGroup();

        //3. Get attributes with values for each document in destination group
        foreach ($destinationGroup->getDocuments() as $currentDocument){
            $attributesSetValuesByDocumentVersionIdCommand = new AttributesStructureByTemplateIdGetCommand($this->container, $currentDocument, $destinationGroup->getTemplate()->id, $currentDocument->getDocumentVersionModel()->id);
            $attributesSetValuesByDocumentVersionIdCommand->execute();
        }

        //4. Build documents compare structure using builder
        $builder = new DocumentCompareStructureBuilder($this->container, $destinationGroup->getDocuments(), $this->onlyDifferences);
        $this->setDocumentCompareStructure($builder->build());
    }

    /**
     * @param $documentCompareStructure
     */
    public function setDocumentCompareStructure($documentCompareStructure){
        $this->documentCompareStructure = $documentCompareStructure;
    }

    /**
     * @return mixed
     */
    public function getDocumentCompareStructure(){
        return $this->documentCompareStructure;
    }

    /**
     * @return mixed
     * @throws CommandException
     */
    protected function retrieveDestinationGroup(){
        try {
            if(!is_null($this->templateId)){
                return $this->getDocumentGroups()[$this->templateId];
            } else {
                return $this->getDocumentGroups()->first();
            }
        } catch(Exception $e) {
            throw new CommandException('Wrong templateId param!');
        }
    }
}