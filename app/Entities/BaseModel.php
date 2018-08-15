<?php
namespace App\Entities;

use Eloquence\Behaviours\CamelCasing;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    use CamelCasing;
}