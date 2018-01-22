<?php


namespace App\Contracts\Entity;
use Illuminate\Support\Collection;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IHasDocumentGroups
{
    public function getDocumentGroups() : Collection;

    public function setDocumentGroups(Collection $collection) : void;
}