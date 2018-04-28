<?php

namespace App\Services\Document;

use App\Contracts\Repositories\IDocumentRepository;
use App\Contracts\Services\ITransaction;
use App\Document;
use App\DocumentVersion;
use Exception;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class TransactionDocumentService extends DocumentService
{
    /**
     * @var ITransaction
     */
    private $transaction;

    public function __construct(
        IDocumentRepository $repository,
        DocumentVersionService $documentVersionService,
        ITransaction $transaction
    )
    {
        parent::__construct($repository, $documentVersionService);
        $this->transaction = $transaction;
    }

    /**
     * @param Document $document
     *
     * @return int
     * @throws Exception
     */
    protected function doCreate(Document $document): int
    {
        $this->transaction->beginTransaction();

        try {
            $result = parent::doCreate($document);
            $this->transaction->commit();
            return $result;
        } catch (Exception $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }

    /**
     * @param Document $document
     * @param DocumentVersion $oldActualVersion
     * @param DocumentVersion $newActualVersion
     * @param bool $createNewVersion
     * @throws Exception
     */
    protected function doUpdate(Document $document, DocumentVersion $oldActualVersion, DocumentVersion $newActualVersion, bool $createNewVersion): void
    {
        $this->transaction->beginTransaction();

        try {
            parent::doUpdate($document, $oldActualVersion, $newActualVersion, $createNewVersion);
            $this->transaction->commit();
        } catch (Exception $e) {
            $this->transaction->rollback();
            throw $e;
        }
    }

    /**
     * @param $oldDV
     * @param $newDV
     * @throws Exception
     */
    protected function doSetActualVersion($oldDV, $newDV)
    {
        $this->transaction->beginTransaction();

        try {
            parent::doSetActualVersion($oldDV, $newDV);
            $this->transaction->commit();
        } catch (Exception $exception) {
            $this->transaction->rollback();
            throw $exception;
        }
    }


}
