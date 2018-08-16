<?php

namespace App\Services;

use App\Contracts\Helpers\ILogger;
use App\Entities\User;
use App\QueryParams\IQueryParamsObject;
use App\Repositories\LogRepository;
use Carbon\Carbon;

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
     * @param User $user
     * @param Carbon $date
     * @return integer
     */
    public function getActionsTotal(Carbon $date, User $user = null): int {
        if($user){
            return $this->repository->getActionsTotalByUserIdAndDate($user->id, $date);
        } else {
            return $this->repository->getActionsTotalByDate($date);
        }
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
