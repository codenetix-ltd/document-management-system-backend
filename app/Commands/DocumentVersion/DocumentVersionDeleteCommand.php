<?php

namespace App\Commands\DocumentVersion;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\DocumentVersion\IDocumentVersionDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\DocumentVersion;
use App\Exceptions\CommandException;
use Exception;

class DocumentVersionDeleteCommand extends ACommand implements IDocumentVersionDeleteCommand
{
    /** @var int $id */
    private $id;

    /**
     * DocumentVersionDeleteCommand constructor.
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $user = DocumentVersion::findOrFail($this->id);
            $user->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
