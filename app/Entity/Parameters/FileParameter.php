<?php

namespace App\Entity\Parameters;

use App\Contracts\Entity\IHasCollectionValue;
use App\Contracts\Entity\IHasStringValue;
use App\Traits\Entity\HasCollectionValue;
use App\Traits\Entity\HasStringValue;
use Illuminate\Support\Collection;

/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
class FileParameter extends AParameter implements IHasStringValue
{
    use HasStringValue;

    /**
     * FileParameter constructor.
     * @param string $name
     * @param string $value
     */
    public function __construct(string $name, string $value)
    {
        parent::__construct($name);
        $this->value = $value;
    }

    public function getTypeName()
    {
        return 'file';
    }
}