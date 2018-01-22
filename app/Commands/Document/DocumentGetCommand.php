<?php

namespace App\Commands\Document;

use App\Adapters\DocumentAdapter;
use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Document\IDocumentGetCommand;
use App\Contracts\Entity\IHasDocument;
use App\Contracts\Exceptions\ICommandException;
use App\Document;
use Exception;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Contracts\Container\Container;

class DocumentGetCommand extends ACommand implements IDocumentGetCommand
{
    /**
     * @var int
     */
    private $id;

    private $context;

    /**
     * @var bool
     */
    private $withTrashed;

    /**
     * DocumentGetCommand constructor.
     * @param Container $container
     * @param $id
     * @param IHasDocument $context
     */
    public function __construct(Container $container, $id, IHasDocument $context)
    {
        parent::__construct($container);
        $this->id = $id;
        $this->context = $context;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $document = Document::withTrashed()->findOrFail($this->id);
        } catch (Exception $e){
            throw new NotFoundHttpException('Document not found');
        }

        $this->context->setDocument((new DocumentAdapter())->transform($document));

        $this->executed = true;
    }

}