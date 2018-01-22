<?php
namespace App\Contracts\Builders;
use App\Entity\Parameters\ParametersCollection;
use App\Entity\Document;


/**
 * @author Andrey Vorobiov<andrew.sprw@gmail.com>
 */
interface IDocumentParameterCollectionBuilder
{

    public function setDocument(Document $document): void;

}