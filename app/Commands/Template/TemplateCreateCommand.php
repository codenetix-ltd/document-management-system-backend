<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateCreateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ITemplate;
use App\Events\Template\TemplateCreateEvent;
use App\Exceptions\CommandException;
use App\Template;
use Exception;
use Illuminate\Support\Facades\Auth;

class TemplateCreateCommand extends ACommand implements ITemplateCreateCommand
{
    /**
     * @var ITemplate
     */
    private $template;

    /**
     * @var array
     */
    private $inputTemplateData;

    /**
     * TemplateCreateCommand constructor.
     * @param array $templateData
     */
    public function __construct(array $templateData)
    {
        $this->inputTemplateData = $templateData;
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
            $template = new Template();
            $template->fill($this->inputTemplateData);
            $template->save();
            $this->template = $template;
            event(new TemplateCreateEvent(Auth::user(), $template));
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
