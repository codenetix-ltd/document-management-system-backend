<?php

namespace App\Repositories;

use App\Entities\Log;

class LogRepository extends BaseRepository
{

    protected function getInstance()
    {
        return new Log();
    }
}
