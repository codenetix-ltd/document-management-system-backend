<?php

namespace App\Services;

abstract class ADocumentAccessService
{
    abstract public function getAvailableFactoriesIds(): array;

    abstract public function getAvailableTemplatesIds(): array;
}