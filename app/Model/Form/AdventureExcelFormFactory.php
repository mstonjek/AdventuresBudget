<?php

declare(strict_types=1);

namespace App\Forms;

use App\Repository\AdventureRepository;
use Nette\Application\UI\Form;
use Nette\Http\FileUpload;
use Nette\SmartObject;
use Nette\Utils\ArrayHash;

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
                    
                }


        };
    }

}