<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\Entity\Adventure;
use App\Repository\AdventureRepository;
use App\Model\Entity\DepartmentEnum;
use App\Repository\BudgetRepository;
use Nette\Application\UI\Form;
use Nette;

final class AdventureFormFactory
{
    use Nette\SmartObject;

    const REQUIRED_MESSAGE = "Nebyla vyplněna všechny povinná pole!";

    public function __construct(
        private readonly FormFactory $factory,
        private readonly AdventureRepository $adventureRepository,
        private readonly BudgetRepository $budgetRepository,
    ){

    }

    public function create(callable $onSuccess, ?Adventure $adventure = null): Form
    {
        $form = $this->factory->create();

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
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('orderNumber')
            ->setDefaultValue($adventure->orderNumber ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('adventureName')
            ->setDefaultValue($adventure->adventureName ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addInteger('participantsCount')
            ->setDefaultValue($adventure->participantsCount ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $items = [];
        foreach (DepartmentEnum::cases() as $department) {
            $items[$department->value] = $department->value;
        }
        $form->addSelect('department')
            ->setItems($items)
            ->setDefaultValue($adventure->department->value ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('providerName')
            ->setDefaultValue($adventure->providerName ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('coordinatorName')
            ->setDefaultValue($adventure->coordinatorName ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('estimatedCost')
            ->setDefaultValue($adventure->estimatedCost ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('actualCost')
            ->setDefaultValue($adventure->actualCost ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);


        $form->addSubmit('submit')
            ->setDefaultValue('Uložit');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess, $adventure): void {
            $adventureCount = $this->adventureRepository->getCount();
            $budget = $this->budgetRepository->find($values->budget);

            if ($adventure === null) {
                $adventure = new Adventure();
                $adventure->serialNumber = $adventureCount + 1;
            }

            $adventure->budget = $budget;
            $adventure->orderNumber = $values->orderNumber;
            $adventure->adventureName = $values->adventureName;
            $adventure->providerName = $values->providerName;
            $adventure->coordinatorName = $values->coordinatorName;
            $adventure->estimatedCost = (float)$values->estimatedCost;
            $adventure->actualCost = (float)$values->actualCost;
            $adventure->department = DepartmentEnum::from($values->department);
            $adventure->adventureDate = new \DateTime();
            $adventure->participantsCount = $values->participantsCount;

            $adventure = $this->adventureRepository->update($adventure);

            $onSuccess($adventure);
        };


        return $form;

    }


}