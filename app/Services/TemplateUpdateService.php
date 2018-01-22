<?php

namespace App\Services;

use App\Contracts\CommandInvokers\IAtomCommandInvoker;
use App\Contracts\Commands\Template\ITemplateUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ITemplate;
use App\Contracts\Services\ITemplateUpdateService;
use Illuminate\Contracts\Container\Container;

class TemplateUpdateService extends AService implements ITemplateUpdateService
{
    /** @var int $id */
    private $id;

    /** @var array $userData */
    private $templateInputData;

    /** @var ITemplate $template */
    private $template;


    public function __construct(Container $container, $id, array $templateInputData)
    {
        parent::__construct($container);

        $this->id = $id;
        $this->templateInputData = $templateInputData;
    }


    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        $invoker = app()->make(IAtomCommandInvoker::class);

        $templateUpdateCommand = app()->makeWith(ITemplateUpdateCommand::class, [
            'id' => $this->id,
            'templateInputData' => $this->templateInputData
        ]);
        $invoker->invoke($templateUpdateCommand);
        $this->template = $templateUpdateCommand->getResult();


        if ($this->templateInputData['orders']) {

        }

        $this->executed = true;
    }

    /**
     * @return ITemplate
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->template;
    }
}