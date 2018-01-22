<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Events\Template\TemplateDeleteEvent;
use App\Exceptions\CommandException;
use App\Template;
use Exception;
use Illuminate\Support\Facades\Auth;

class TemplateDeleteCommand extends ACommand implements ITemplateDeleteCommand
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
            $template = Template::findOrFail($this->id);
            event(new TemplateDeleteEvent(Auth::user(), $template));
            $template->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
