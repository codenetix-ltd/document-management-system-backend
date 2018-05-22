<?php

namespace App\Services;

use App\Contracts\Helpers\ILogger;
use App\Repositories\LogRepository;
use App\Entities\User;

/**
 * Created by Codenetix team <support@codenetix.com>
 */
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
     * @param $userId
     * @return mixed
     */
    public function list($userId){
        return $this->repository->paginateByUser($userId);

    }

    public function write(User $user, string $body, int $referenceId, string $referenceType): void
    {
        $this->repository->create([
            'user_id' => $user->id,
            'body' => $body,
            'reference_id' => $referenceId,
            'reference_type' => $referenceType
        ]);
    }
}