<?php

namespace App\Commands\DocumentVersion;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionGetCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\IDocumentVersion;
use App\DocumentVersion;
use App\Exceptions\CommandException;
use Exception;

class DocumentVersionGetCommand extends ACommand implements IDocumentVersionGetCommand
{
    /** @var int $id */
    private $id;

    /** @var IDocumentVersion $documentVersion */
    private $documentVersion;

    /**
     * DocumentVersionGetCommand constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return IDocumentVersion
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->documentVersion;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $this->documentVersion = DocumentVersion::findOrFail($this->id);
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}