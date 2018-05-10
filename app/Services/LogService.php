<?php

namespace App\Services;

use App\Contracts\Helpers\ILogger;
use App\Contracts\Repositories\ILogRepository;
use App\Log;
use App\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LogService implements ILogger
{
    /**
     * @var ILogRepository
     */
    private $repository;

    public function __construct(ILogRepository $repository)
    {
        $this->repository = $repository;
    }

    public function write(User $user, string $body, int $referenceId, string $referenceType): void
    {
        $log = new Log();
        $log->setBody($body)
            ->setUserId($user->getId())
            ->setReferenceId($referenceId)
            ->setReferenceType($referenceType);

        $this->repository->save($log);
    }

    public function list($userId = null): LengthAwarePaginator
    {
        return $this->repository->list($userId);
    }
}
