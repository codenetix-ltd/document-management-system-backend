<?php

namespace App\Commands\Template;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Template\ITemplateUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ITemplate;
use App\Exceptions\CommandException;
use App\Template;
use Exception;

class TemplateUpdateCommand extends ACommand implements ITemplateUpdateCommand
{
    /** @var int $id */
    private $id;

    /** @var ITemplate $template */
    private $template;

    /** @var array $templateInputData */
    private $templateInputData;

    /**
     * TemplateUpdateCommand constructor.
     * @param $id
     * @param array $templateInputData
     */
    public function __construct($id, array $templateInputData)
    {
        $this->id = $id;
        $this->templateInputData = $templateInputData;
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
            $template = Template::findOrFail($this->id);
            $template->fill($this->templateInputData);
            $template->save();
            $this->template = $template;
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }

}