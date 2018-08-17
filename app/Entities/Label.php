<?php

namespace App\Entities;

use App\Contracts\Entity\IHasTitle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Label.
 *
 * @property int $id
 * @property string $name
 * @property Carbon $createdAt
 * @property Carbon $updatedAt
 */
class Label extends BaseModel implements IHasTitle
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    public $enforceCamelCase = false;
    public function getTitle(): string
    {
        return $this->name;
    }
}
