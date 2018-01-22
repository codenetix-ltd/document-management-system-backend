<?php

namespace App\Entity;
use App\Template;
use Illuminate\Support\Collection;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class DocumentGroup
{
    private $documentsTotal;

    private $template;

    private $documents;

    public function __construct(int $documentsTotal, Template $template)
    {
        $this->documentsTotal = $documentsTotal;
        $this->template = $template;
        $this->documents = new Collection();
    }

    /**
     * @return Template
     */
    public function getTemplate() : Template
    {
        return $this->template;
    }

    /**
     * @param Template $template
     */
    public function setTemplate(Template $template) : void
    {
        $this->template = $template;
    }

    /**
     * @return int
     */
    public function getDocumentsTotal() : int
    {
        return $this->documentsTotal;
    }

    /**
     * @param int $documentsTotal
     */
    public function setDocumentsTotal(int $documentsTotal) : void
    {
        $this->documentsTotal = $documentsTotal;
    }

    /**
     * @return Collection
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    /**
     * @param Document $document
     */
    public function addDocument(Document $document) : void
    {
        $this->documents->push($document);
    }
}