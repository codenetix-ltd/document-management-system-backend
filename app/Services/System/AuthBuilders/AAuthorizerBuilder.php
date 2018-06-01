<?php

namespace App\System\AuthBuilders;

use App\Services\Authorizers\AAuthorizer;
use Illuminate\Database\Eloquent\Model;

abstract class AAuthorizerBuilder
{
    /**
     * @param Model|null $target
     * @return AAuthorizer
     */
    abstract public function build(Model $target = null) : AAuthorizer;
}
