<?php

namespace App\Events\Label;

use App\Events\Event;
use App\Entities\Label;

abstract class AbstractLabelEvent extends Event
{
    /**
     * @var Label
     */
    private $label;

    /**
     * AbstractLabelEvent constructor.
     * @param Label $label
     */
    public function __construct(Label $label)
    {
        $this->label = $label;
    }

    /**
     * @return Label
     */
    public function getLabel(): Label
    {
        return $this->label;
    }
}
