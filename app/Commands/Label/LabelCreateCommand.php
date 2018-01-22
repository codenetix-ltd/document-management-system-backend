<?php

namespace App\Commands\Label;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Label\ILabelCreateCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Contracts\Models\ILabel;
use App\Events\Label\LabelCreateEvent;
use App\Label;
use Illuminate\Support\Facades\Auth;

class LabelCreateCommand extends ACommand implements ILabelCreateCommand
{
    /**
     * @var ILabel
     */
    private $label;

    /**
     * @var array
     */
    private $inputData;

    /**
     * LabelCreateCommand constructor.
     * @param array $inputData
     */
    public function __construct(array $inputData)
    {
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
        $label = new Label();
        $label->fill($this->inputData);
        $label->save();
        $this->label = $label;
        event(new LabelCreateEvent(Auth::user(), $label));

        $this->executed = true;
    }
}
