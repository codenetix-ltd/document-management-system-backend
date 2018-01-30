<?php

namespace App\Contracts\Models;

interface ITemplate
{
    public function setName(string $name): ITemplate;
    public function getName(): string;

    public function setCreated(string $created): ITemplate;
    public function getCreated(): string;

    public function setUpdated(string $updated): ITemplate;
    public function getUpdated(): string;
}