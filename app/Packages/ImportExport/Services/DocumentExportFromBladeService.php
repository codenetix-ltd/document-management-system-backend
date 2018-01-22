<?php

namespace App\Packages\ImportExport\Services;

use App\Builders\ParameterBuilders\DocumentExportParameterCollectionBuilder;
use App\Exceptions\CommandException;
use App\Services\ADocumentViewService;
use Illuminate\Container\Container;
use Maatwebsite\Excel\Classes\LaravelExcelWorksheet;
use Maatwebsite\Excel\Facades\Excel;

class DocumentExportFromBladeService extends ADocumentExportService
{
    const FORMAT_PDF = 'pdf';
    const FORMAT_XLSX = 'xlsx';

    private $availableFormats = [self::FORMAT_XLSX, self::FORMAT_PDF];

    public function __construct(Container $container, $documentId, array $params, bool $publish, $fileName = null, $format = null)
    {
        if (!in_array($format, $this->availableFormats)) throw new CommandException('Unsupported format');

        parent::__construct($container, $documentId, $params, $publish, $fileName, $format);
    }

    public function execute()
    {
        $parameterBuilder = new DocumentExportParameterCollectionBuilder();
        /** @var ADocumentViewService $service */
        $service = $this->container->makeWith(ADocumentViewService::class, [
            'container' => $this->container,
            'documentId' => $this->getDocumentId(),
            'parameterBuilder' => $parameterBuilder
        ]);
        $service->execute();
        $document = $service->getDocument();

        $excel = Excel::create($this->getFileName());
        $excel->sheet('sheet1', function($sheet) use ($document){
            /** @var LaravelExcelWorksheet $sheet */
            $sheet->loadView($this->getView(), [
                'document' => $document,
                'viewMode' => true,
                'filter' => $this->getParams()
            ])->setStyle(array(
                'font' => array(
                    'name'      =>  'Calibri',
                    'size'      =>  14
                )
            ));
            $highestRowAndColumn = $sheet->getView()->parse($sheet)->getHighestRowAndColumn();
            $sheet->setBorder("A1:".$highestRowAndColumn['column'].$highestRowAndColumn['row'], 'none');
        });

        $file = $excel->store($this->getFormat(), false, true);
        $this->setFileUrl(url('/storage/exports') . '/' . $file['file']);
    }

    private function getView()
    {
        switch ($this->getFormat()) {
            case 'xlsx': return 'export_templates.document_export_xlsx';
            case 'pdf' : return 'export_templates.document_export_pdf';

        }
    }
}
