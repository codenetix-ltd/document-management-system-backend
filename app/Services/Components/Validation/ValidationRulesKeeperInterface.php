<?php

namespace App\Services\Components\Validation;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
interface ValidationRulesKeeperInterface
{
    /**
     * @param string $type
     *
     * @return array
     */
    public function getRules(string $type): array;
}
