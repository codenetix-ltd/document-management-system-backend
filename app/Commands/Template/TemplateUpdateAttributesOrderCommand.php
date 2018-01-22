<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateUpdateAttributesOrderCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Exceptions\CommandException;
use App\Template;
use Exception;

class TemplateUpdateAttributesOrderCommand extends ACommand implements ITemplateUpdateAttributesOrderCommand
{
    /** @var int $id */
    private $id;

    /**
     * TemplateDeleteCommand constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $user = Template::findOrFail($this->id);
            $user->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
