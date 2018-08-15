<?php

namespace App\Services;

use App\Contracts\Helpers\ILogger;
use App\QueryParams\IQueryParamsObject;
use App\Repositories\LogRepository;

class LogService implements ILogger
{
    use CRUDServiceTrait;

    /**
     * LogService constructor.
     * @param LogRepository $repository
     */
    public function __construct(LogRepository $repository)
    {
        $this->setRepository($repository);
    }

    /**
     * @param integer $userId
     * @param string  $body
     * @param integer $referenceId
     * @param string  $referenceType
     * @return mixed|void
     */
    public function write(int $userId, string $body, int $referenceId, string $referenceType)
    {
        $this->repository->create([
            'userId' => $userId,
            'body' => $body,
            'referenceId' => $referenceId,
            'referenceType' => $referenceType
        ]);
    }
}
