<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateGetCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ITemplate;
use App\Exceptions\CommandException;
use App\Template;
use Exception;

class TemplateGetCommand extends ACommand implements ITemplateGetCommand
{
    /** @var int $id */
    private $id;

    /** @var ITemplate $template */
    private $template;

    /**
     * TemplateGetCommand constructor.
     * @param int $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return ITemplate
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->template;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $this->template = Template::findOrFail($this->id);
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}