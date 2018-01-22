<?php

namespace App\Packages\ImportExport\Services;

use App\Packages\ImportExport\Contracts\Entity\IHasParams;
use App\Packages\ImportExport\Contracts\Entity\IHasFileName;
use App\Packages\ImportExport\Contracts\Entity\IHasFileUrl;
use App\Packages\ImportExport\Contracts\Entity\IHasFormat;
use App\Packages\ImportExport\Contracts\Entity\IHasPublish;
use App\Services\AService;
use Illuminate\Container\Container;

abstract class AExportService extends AService implements IHasFileName, IHasFileUrl, IHasParams, IHasFormat, IHasPublish
{
    private $params;
    private $fileName;
    private $format;
    private $publish;
    private $fileUrl;

    public function __construct(Container $container, array $params, bool $publish, string $fileName = null, string $format = null)
    {
        parent::__construct($container);

        $this->params = $params;
        $this->publish = $publish;
        $fileName = !empty($fileName) ? $fileName : 'export';
        $this->fileName = $fileName . '_' . time();
        $this->format = $format;
    }


    public function getFileName() : string
    {
        return $this->fileName;
    }

    public function setFileName($fileName) : void
    {
        $this->fileName = $fileName;
    }

    public function getFileUrl() : string
    {
        return $this->fileUrl;
    }

    public function setFileUrl($fileUrl) : void
    {
        $this->fileUrl = $fileUrl;
    }

    public function getParams() : array
    {
        return $this->params;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getFormat() : string
    {
        return $this->format;
    }

    public function setFormat(string $format): void
    {
        $this->format = $format;
    }

    public function setPublish(bool $publish): void
    {
        $this->publish = $publish;
    }

    public function isPublish() : bool
    {
        return $this->publish;
    }
}
