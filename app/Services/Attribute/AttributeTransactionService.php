<?php

namespace App\Services\Attribute;

use App\Attribute;
use App\Contracts\Repositories\IAttributeRepository;
use App\Contracts\Repositories\ITypeRepository;
use App\Contracts\Services\ITransaction;
use App\Exceptions\FailedAttributeCreateException;
use Exception;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class AttributeTransactionService extends AttributeService
{
    /**
     * @var ITransaction
     */
    private $transaction;

    public function __construct(
        IAttributeRepository $repository,
        ITypeRepository $typeRepository,
        ITransaction $transaction
    )
    {
        parent::__construct($repository, $typeRepository);
        $this->transaction = $transaction;
    }

    /**
     * @param Attribute $attribute
     * @return Attribute
     * @throws FailedAttributeCreateException
     */
    protected function createAttributeWithTableType(Attribute $attribute): Attribute
    {
        $this->transaction->beginTransaction();

        try {
            $result = parent::createAttributeWithTableType($attribute);
            $this->transaction->commit();
            return $result;
        } catch (Exception $e) {
            $this->transaction->rollback();
            throw new FailedAttributeCreateException($e->getMessage(), $e->getCode(), $e);
        }
    }


}
