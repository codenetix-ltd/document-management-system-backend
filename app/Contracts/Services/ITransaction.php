<?php

namespace App\Contracts\Services;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface ITransaction
{
    public function beginTransaction();
    public function rollback();
    public function commit();
}
