<?php

namespace App\Contracts\Entity;

use Carbon\Carbon;

interface IDateRange
{
    /**
     * DateRange constructor.
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate);

    /**
     * @return Carbon|null
     */
    public function getStartDate();

    /**
     * @return Carbon|null
     */
    public function getEndDate();
}