<?php

namespace App\Commands\Label;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Label\ILabelUpdateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ILabel;
use App\Events\Label\LabelUpdateEvent;
use App\Exceptions\CommandException;
use App\Label;
use Exception;
use Illuminate\Support\Facades\Auth;

class LabelUpdateCommand extends ACommand implements ILabelUpdateCommand
{
    /** @var int $id */
    private $id;

    /** @var ILabel $label */
    private $label;

    /** @var array $inputData */
    private $inputData;

    /**
     * LabelUpdateCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
     * @param array $inputData
     */
    public function __construct($id, array $inputData)
    {
        $this->id = $id;
        $this->inputData = $inputData;
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
            $label = Label::findOrFail($this->id);
            $label->fill($this->inputData);
            $label->save();
            $this->label = $label;
            event(new LabelUpdateEvent(Auth::user(), $label));
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
