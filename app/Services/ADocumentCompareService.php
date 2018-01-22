<?php

namespace App\Services;

use App\Contracts\Commands\ACommand;
use App\Contracts\Entity\IHasDocumentGroups;
use App\Contracts\Services\IDocumentCompareService;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

abstract class ADocumentCompareService extends ACommand implements IDocumentCompareService, IHasDocumentGroups
{

    protected $documentIds;

    private $documentGroups;

    protected $templateId;

    protected $onlyDifferences;

    /**
     * DocumentCompareService constructor.
     * @param Container $container
     * @param array $documentIds
     * @param int $templateId
     */
    public function __construct(Container $container, array $documentIds, bool $onlyDifferences, int $templateId = null)
    {
        parent::__construct($container);
        $this->documentIds = $documentIds;
        $this->templateId = $templateId;
        $this->documentGroups = new Collection();
        $this->onlyDifferences = $onlyDifferences;
    }

    public function getDocumentGroups() : Collection
    {
        return $this->documentGroups;
    }

    public function setDocumentGroups(Collection $collection) : void
    {
        $this->documentGroups = $collection;
    }
}