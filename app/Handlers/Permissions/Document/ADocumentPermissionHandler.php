<?php

namespace App\Handlers\Permissions\Document;

use App\Context\DocumentAuthorizeContext;

abstract class ADocumentPermissionHandler
{
    abstract public function handle(DocumentAuthorizeContext $context) : bool;

    abstract public function getPermissionName() : string;
}