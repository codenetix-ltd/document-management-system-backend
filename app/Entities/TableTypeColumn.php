<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TableTypeColumn
 * @package App\Entities
 *
 * @property int $parent_attribute_id
 * @property string $name
 */
class TableTypeColumn extends BaseModel
{
    public $timestamps = false;
    public $enforceCamelCase = false;
}
