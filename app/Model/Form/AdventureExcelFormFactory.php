<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\Entity\Budget;
use App\Repository\AdventureRepository;
use App\Model\Entity\Adventure;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\SmartObject;
use App\Model\Entity\DepartmentEnum;
use App\Repository\BudgetRepository;
use Nette\Utils\ArrayHash;

use PhpOffice\PhpSpreadsheet\IOFactory;

final class AdventureExcelFormFactory
{
    use SmartObject;

    public function __construct(
        private readonly FormFactory         $factory,
        private readonly AdventureRepository $adventureRepository,
        private readonly BudgetRepository $budgetRepository,
    ){
    }

    public function create(callable $onSuccess): Form
    {
        $form  = $this->factory->create();

        $form->addUpload('excelFile', 'Upload Excel File')
            ->setRequired('Please upload an Excel file')
            ->addRule(Form::MIME_TYPE, 'The file must be an Excel file.', [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                'application/vnd.ms-excel'
            ]);

        $currentBudgets = $this->budgetRepository->getYearBudgets();
        $items = [];
        foreach ($currentBudgets["yearBudgets"] as $budget) {
            $items[$budget->budgetId] = sprintf(
                '%d - Semester %d, Part %d',
                $budget->year,
                $budget->semester,
                $budget->part
            );
        }

        $form->addSelect('budget')
            ->setItems($items)
            ->setDefaultValue($adventure->budget->budgetId ?? null)
            ->setRequired("Please select a budget");

        $form->addSubmit('submit', 'Upload')
            ->setDefaultValue('Uložit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
                if ($values->excelFile->isOk()) {
                    $budget = $this->budgetRepository->find($values->budget);
                    $adventures = $this->processExcelFile($values->excelFile, $budget);
                    $onSuccess($adventures);
                }
        };

        return $form;
    }

    private function processExcelFile($file, Budget $budget): array
    {
        $tempFilePath = __DIR__ . "/www/tempFiles" . $file->getName();
        $file->move($tempFilePath);

        $spreadsheet = IOFactory::load($tempFilePath);
        $worksheet = $spreadsheet->getActiveSheet();
        $data = $worksheet->toArray();

        $header = array_shift($data);
        $adventureCount = $this->adventureRepository->getCount();
        $adventures = [];

        foreach ($data as $row) {
            $adventureCount++;

            $adventure = new Adventure();
            $adventure->serialNumber = $adventureCount;
            $adventure->orderNumber = $row[0];
            $adventure->adventureName = $row[1];
            $adventure->adventureDate = new \DateTime($row[2]);
            $adventure->participantsCount = (int)$row[3];
            $adventure->department = DepartmentEnum::from($row[4]);
            $adventure->providerName = $row[5];
            $adventure->coordinatorName = $row[6];
            $adventure->estimatedCost = (float) $row[7];
            $adventure->actualCost = isset($row[8]) ? (float) $row[8] : null;
            $adventure->budget = $budget;

            $this->adventureRepository->update($adventure);
            $adventures[] = $adventure;
        }

        unlink($tempFilePath);
        return $adventures;
    }

}