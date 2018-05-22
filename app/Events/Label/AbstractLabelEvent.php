<?php

namespace App\Events\Label;

use App\Events\Event;
use App\Entities\Label;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractLabelEvent extends Event
{
    /**
     * @var Label
     */
    private $label;

    public function __construct(Label $label)
    {
        $this->label = $label;
    }

    public function getLabel(): Label
    {
        return $this->label;
    }
}
