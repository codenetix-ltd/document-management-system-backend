<?php

namespace App\Commands\Document;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Document\IDocumentDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use App\Events\Document\DocumentArchiveEvent;
use App\Events\Document\DocumentDeleteEvent;
use App\Exceptions\CommandException;
use Exception;
use Illuminate\Support\Facades\Auth;

class DocumentDeleteCommand extends ACommand implements IDocumentDeleteCommand
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $force;

    /**
     * @var
     */
    private $substituteDocumentId;

    /**
     * DocumentDeleteCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $container
     * @param $id
     * @param null $substituteDocumentId
     * @param bool $force
     */
    public function __construct($container, $id, $substituteDocumentId = null, $force = false)
    {
        parent::__construct($container);

        $this->id = $id;
        $this->force = $force;
        $this->substituteDocumentId = $substituteDocumentId;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $document = Document::findOrFail($this->id);

            if($this->substituteDocumentId){
                $document->update(['substitute_document_id' => $this->substituteDocumentId]);
            }

            if ($this->force) {
                event(new DocumentDeleteEvent(Auth::user(), $document));
                $document->forceDelete();
            } else {
                event(new DocumentArchiveEvent(Auth::user(), $document));
                $document->delete();
            }
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
