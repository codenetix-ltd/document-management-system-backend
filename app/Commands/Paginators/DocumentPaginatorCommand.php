<?php

namespace App\Commands\Paginators;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Paginators\IDocumentPaginatorCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class DocumentPaginatorCommand extends ACommand implements IDocumentPaginatorCommand
{
    /** @var LengthAwarePaginator $user */
    private $paginator;

    /**
     * @return LengthAwarePaginator
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->paginator;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $this->paginator = Document::paginate(15);

        $this->executed = true;
    }

}