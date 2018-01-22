<?php

namespace App\Exceptions;

use App\Contracts\Exceptions\ICommandException;
use Exception;

class CommandException extends Exception implements ICommandException
{
}