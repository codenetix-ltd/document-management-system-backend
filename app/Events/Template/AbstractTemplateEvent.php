<?php

namespace App\Events\Template;

use App\Events\Event;
use App\Template;

/**
 * @author Vladimir Barmotin <barmotinvladimir@gmail.com>
 */
abstract class AbstractTemplateEvent extends Event
{
    /**
     * @var Template
     */
    private $template;

    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function getTemplate(): Template
    {
        return $this->template;
    }
}
