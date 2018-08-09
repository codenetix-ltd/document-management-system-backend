<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TableTypeRow
 * @package App\Entities
 *
 * @property int $parent_attribute_id
 * @property string $name
 */
class TableTypeRow extends BaseModel
{
    public $timestamps = false;
    public $enforceCamelCase = false;
}
