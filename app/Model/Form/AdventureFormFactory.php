<?php

declare(strict_types=1);

namespace App\Forms;

use App\Model\Entity\Adventure;
use App\Repository\AdventureRepository;
use App\Model\Entity\DepartmentEnum;
use Nette\Application\UI\Form;
use Nette\SmartObject;

final class AdventureFormFactory
{
    use SmartObject;

    const REQUIRED_MESSAGE = "Nebyla vyplněna všechny povinná pole!";

    public function __construct(
        private readonly FormFactory         $factory,
        private readonly AdventureRepository $adventureRepository,
    ){

    }

    public function create(callable $onSuccess, Adventure $adventure): Form
    {

        $form = $this->factory->create();

        $form->addText('orderNumber')
            ->setDefaultValue($adventure->orderNumber ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('adventureName')
            ->setDefaultValue($adventure->name ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addDateTime('date')
            ->setDefaultValue($adventure->date ?? null)
            ->setRequired(self::REQUIRED_MESSAGE);

        $items = [];
        foreach (DepartmentEnum::cases() as $department) {
            $items[$department->value] = $department->value;
        }
        $form->addSelect('department')
            ->setDefaultValue($adventure->department ?? null)
            ->setItems($items)
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

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess): void {
            if ($adventure === null) {
                $adventure = new Adventure();
            }

            $adventure->orderNumber = $values->orderNumber;
            $adventure->adventureName = $values->adventureName;
            $adventure->providerName = $values->providerName;
            $adventure->coordinatorName = $values->coordinatorName;
            $adventure->estimatedCost = $values->estimatedCost;
            $adventure->actualCost = $values->actualCost;
            $adventure->department = $values->department;
            $adventure->date = $values->date;

            $adventure = $this->adventureRepository->update($adventure);
            $onSuccess($adventure);

        };

        return $form;

    }


}