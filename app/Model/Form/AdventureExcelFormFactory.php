<?php

declare(strict_types=1);

namespace App\Forms;

use App\Repository\AdventureRepository;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

use PhpOffice\PhpSpreadsheet\IOFactory;

final class AdventureExcelFormFactory
{
    use SmartObject;

    public function __construct(
        private readonly FormFactory         $factory,
        private readonly AdventureRepository $adventureRepository,
    ){
    }

    public function create(callable $onSuccess): Form
    {
        $form  = $this->factory->create();

        $form->addUpload('excelFile', 'Upload Excel File')
            ->setRequired('Please upload an Excel file')
            ->addRule(Form::UPLOAD, 'The file must be an Excel file.', ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/vnd.ms-excel']);

        $form->addSubmit('submit', 'Upload')
            ->setDefaultValue('Uložit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
                if ($values->excelFile->isOk()) {
                    $adventures = $this->processExcelFile($values->excelFile);
                    $onSuccess($adventures);
                }
        };
    }

    private function processExcelFile($file): array
    {
        $spreadsheet = IOFactory::load($file);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        $header = array_shift($data);
        $adventureCount = $this->adventureRepository->getCount();
        $iterator = 0;
        $adventures = [];

        foreach ($data as $row) {
            $adventure = new Adventure();
            $adventure->serialNumber = $adventureCount++;
            $adventure->orderNumber = $row[0];
            $adventure->adventureName = $row[1];
            $adventure->date = new \DateTime($row[2]);
            $adventure->department = DepartmentEnum::from($row[3]);
            $adventure->providerName = $row[4];
            $adventure->coordinatorName = $row[5];
            $adventure->estimatedCost = (float)$row[6];
            $adventure->actualCost = $row[7] !== null ? (float)$row[7] : null;

            $this->adventureRepository->update($adventure);
            $adventures[$iterator++] = $adventure;
        }
        return $adventures;
    }

}