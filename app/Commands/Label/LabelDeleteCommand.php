<?php

namespace App\Commands\Label;

use App\Contracts\Commands\ACommand;
use App\Contracts\Commands\Label\ILabelDeleteCommand;
use App\Contracts\Exceptions\ICommandException;
use App\Events\Label\LabelDeleteEvent;
use App\Exceptions\CommandException;
use App\Label;
use Exception;
use Illuminate\Support\Facades\Auth;

class LabelDeleteCommand extends ACommand implements ILabelDeleteCommand
{
    /** @var int $id */
    private $id;

    /**
     * LabelDeleteCommand constructor.
     * @param \Illuminate\Contracts\Container\Container $id
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
            $label = Label::findOrFail($this->id);
            event(new LabelDeleteEvent(Auth::user(), $label));
            $label->delete();
        } catch (Exception $e){
            throw new CommandException();
        }

        $this->executed = true;
    }
}
