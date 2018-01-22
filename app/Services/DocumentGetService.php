<?php

namespace App\Services;

use App\Contracts\Commands\Document\IDocumentGetCommand;

class DocumentGetService extends ADocumentGetService
{
    public function execute()
    {
        $documentGetCommand = $this->container->makeWith(IDocumentGetCommand::class, [
            'container' => $this->container,
            'id' => $this->getDocumentId(),
            'context' => $this
        ]);

        $documentGetCommand->execute();
    }
}