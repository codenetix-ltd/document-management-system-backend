<?php

namespace App\Commands\Document;

use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasDocument;
use App\Contracts\Entity\IHasDocumentGroups;
use App\Contracts\Exceptions\ICommandException;
use App\Entity\Document;
use App\Entity\DocumentGroup;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

class DocumentGroupsListCommand extends ACommand implements IHasDocument
{

    private $context;

    private $document;

    private $documentIds;

    public function __construct(Container $container, IHasDocumentGroups $context, array $documentIds)
    {
        parent::__construct($container);
        $this->context = $context;
        $this->documentIds = $documentIds;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $groups = new Collection();
        foreach ($this->documentIds as $documentId) {
            $documentGetCommand = new DocumentGetCommand($this->container, $documentId, $this);
            $documentGetCommand->execute();

            if (!$groups->has($this->getDocument()->getTemplateModel()->id)) {
                $currentGroup = new DocumentGroup(1, $this->getDocument()->getTemplateModel());
                $groups->put($this->getDocument()->getTemplateModel()->id, $currentGroup);
            } else {
                $currentGroup = $groups->get($this->getDocument()->getTemplateModel()->id);
                $currentGroup->setDocumentsTotal($currentGroup->getDocumentsTotal() + 1);
            }

            $currentGroup->addDocument($this->getDocument());
        }

        $this->executed = true;
        $this->context->setDocumentGroups($groups);
    }

    public function getDocument() : Document
    {
        return $this->document;
    }

    public function setDocument(Document $document) : void
    {
        $this->document = $document;
    }
}
