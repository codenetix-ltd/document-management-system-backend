<?php

namespace App\Services;

use App\Contracts\Helpers\ILogger;
use App\Repositories\LogRepository;

class LogService implements ILogger
{
    /**
     * @var LogRepository
     */
    protected $repository;

    /**
     * LogService constructor.
     * @param LogRepository $repository
     */
    public function __construct(LogRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param integer $userId
     * @return mixed
     */
    public function list(int $userId)
    {
        return $this->repository->paginateByUser($userId);
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
            'user_id' => $userId,
            'body' => $body,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType
        ]);
    }
}
