<?php

namespace App;

use App\Contracts\Models\IFactory;
use Illuminate\Database\Eloquent\Model;

class Factory extends Model implements IFactory
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getViewURL(){
        return '#';
    }

    public function getViewURLLink(){
        return $this->name;
    }
}
