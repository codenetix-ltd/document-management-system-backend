<?php

namespace App\Entity;

use App\Contracts\Entity\IDateRange;
use Carbon\Carbon;

/**
 * Class DateRange
 * @package App\Entity
 */
class DateRange implements IDateRange
{
    /**
     * @var Carbon|null
     */
    private $startDate;

    /**
     * @var Carbon|null
     */
    private $endDate;

    /**
     * DateRange constructor.
     * @param $startDate
     * @param $endDate
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = !empty($startDate) ? Carbon::parse($startDate)->startOfDay() : null;
        $this->endDate = !empty($endDate) ? Carbon::parse($endDate)->endOfDay() : null;
    }

    /**
     * @return Carbon|null
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return Carbon|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}