<?php

namespace App\Presenters;

use App\Service\ExcelService;
use Nette;
use Nette\Application\Responses\FileResponse;

class DownloadPresenter extends Nette\Application\UI\Presenter
{
    private ExcelService $excelService;

    public function __construct(ExcelService $excelService) {
        $this->excelService = $excelService;
    }

    public function actionGenerateExcel(): void
    {
        $filename = 'adventures.xlsx';
        $filePath = __DIR__ . '/../../www/files/' . $filename;

        $this->excelService->createAdventureExcelFile($filename);

        $this->sendResponse(new FileResponse($filePath, $filename));
    }

}