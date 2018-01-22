<?php

namespace App\Commands\Document;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Document\IDocumentsDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use App\Events\Document\BulkDocumentArchiveEvent;
use App\Events\Document\BulkDocumentDeleteEvent;
use App\Exceptions\CommandException;
use Exception;
use Illuminate\Support\Facades\Auth;

class DocumentsDeleteCommand extends ACommand implements IDocumentsDeleteCommand
{
    /**
     * @var array
     */
    private $ids;

    /**
     * @var int
     */
    private $documentsDeleted;

    /**
     * @var bool
     */
    private $force;

    /**
     * @var
     */
    private $substituteDocumentId;

    /**
     * DocumentsDeleteCommand constructor.
     * @param array $ids
     * @param $substituteDocumentId
     * @param bool $force
     */
    public function __construct(array $ids, $substituteDocumentId = null, $force = false)
    {
        $this->ids = $ids;
        $this->force = $force;
        $this->substituteDocumentId = $substituteDocumentId;
    }

    /**
     * @return int
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->documentsDeleted;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $query = Document::query()->whereIn('id', $this->ids);

            if($this->substituteDocumentId){
                Document::query()->whereIn('id', $this->ids)->update(['substitute_document_id' => $this->substituteDocumentId]);
            }

            if ($this->force) {
                $this->documentsDeleted = $query->forceDelete();

                event(new BulkDocumentDeleteEvent(Auth::user(), $this->ids));
            } else {
                $this->documentsDeleted = $query->delete();

                event(new BulkDocumentArchiveEvent(Auth::user(), $this->ids));
            }
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
