<?php

namespace App\Events\Template;

use App\Events\Event;
use App\Entities\Template;

abstract class AbstractTemplateEvent extends Event
{
    /**
     * @var Template
     */
    private $template;

    /**
     * AbstractTemplateEvent constructor.
     * @param Template $template
     */
    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    /**
     * @return Template
     */
    public function getTemplate(): Template
    {
        return $this->template;
    }
}
