<?php

namespace App\Commands\Label;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Label\ILabelGetCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ILabel;
use App\Exceptions\CommandException;
use App\Label;
use Exception;

class LabelGetCommand extends ACommand implements ILabelGetCommand
{
    /** @var int $id */
    private $id;

    /** @var ILabel $label */
    private $label;

    /**
     * LabelGetCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return ILabel
     */
    public function getResult()
    {
        $this->isExecuted();

        return $this->label;
    }

    /**
     * @throws ICommandException
     * @return void
     */
    public function execute()
    {
        try {
            $this->label = Label::findOrFail($this->id);
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}