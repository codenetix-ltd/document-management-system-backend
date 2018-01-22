<?php

namespace App\Commands\Tag;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Tag\ITagListCommand;
use App\Contracts\Models\ITag;
use App\Tag;
use Illuminate\Database\Eloquent\Collection;

class TagListCommand extends ACommand implements ITagListCommand
{
    /** @var array $columns */
    private $columns;

    /** @var Collection|ITag $collection */
    private $collection;

    /**
     * TagListCommand constructor.
     * @param array $columns
     */
    public function __construct($columns = ['*'])
    {
        $this->columns = $columns;
    }

    /**
     * @return Collection|ITag
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
        $this->collection = Tag::all($this->columns);

        $this->executed = true;
    }
}
