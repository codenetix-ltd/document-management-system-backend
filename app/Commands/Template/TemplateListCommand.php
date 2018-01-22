<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateListCommand;
use App\Contracts\Models\ITemplate;
use App\Template;
use Illuminate\Contracts\Container\Container;
use Illuminate\Database\Eloquent\Collection;

class TemplateListCommand extends ACommand implements ITemplateListCommand
{
    /**
     * @var array
     */
    private $columns;

    /**
     * @var array
     */
    private $ids;

    /** @var Collection|ITemplate $collection */
    private $collection;

    private $strict;

    public function __construct(Container $container, $columns = ['*'], array $ids = [], $strict = false)
    {
        parent::__construct($container);
        $this->columns = $columns;
        $this->ids = $ids;
        $this->strict = $strict;
    }

    /**
     * @return Collection|ITemplate
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->collection;
    }

    /**
     * @return void
     */
    public function execute()
    {
        $query = Template::query();
        if (count($this->ids) || $this->strict) {
            $query->whereIn('id', $this->ids);
        }
        $this->collection = $query->get($this->columns);

        $this->executed = true;
    }
}
