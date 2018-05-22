<?php

namespace App\Repositories;

use App\Contracts\Repositories\ILogRepository;
use App\Log;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
class LogRepository extends EloquentRepository implements ILogRepository
{

    public function list($userId = null): LengthAwarePaginator
    {
        $query = Log::query();

        if (!is_null($userId)) {
            $query->where('user_id', $userId);
        }

        return $query->paginate();
    }
}
