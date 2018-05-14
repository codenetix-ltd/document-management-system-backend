<?php

namespace App\System\AuthBuilders;

use App\Services\Authorizers\AAuthorizer;

abstract class AAuthorizerBuilder
{
    abstract public function build($target = null) : AAuthorizer;
}