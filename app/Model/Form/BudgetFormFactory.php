<?php
declare(strict_types=1);

namespace App\Forms;

use App\Model\Entity\Budget;
use Nette\Application\UI\Form;
use Nette;
use App\Repository\BudgetRepository;
use App\Model\Entity\DepartmentEnum;

class BudgetFormFactory
{
    use Nette\SmartObject;

    private const REQUIRED_MESSAGE = "Nebyla vyplněna všechny povinná pole!";

    public function __construct(
        private readonly FormFactory $factory,
        private readonly BudgetRepository $budgetRepository
    ) {
    }

    public function create(callable $onSuccess, ?Buget $budget = null): Form
    {
        $form = $this->factory->create();


        $form->addText('year', 'Year:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE)
            ->setHtmlAttribute('min', 2023)
            ->setHtmlAttribute('max', 2099);


        $form->addText('semester', 'Semester:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE)
            ->setHtmlAttribute('min', 1)
            ->setHtmlAttribute('max', 2);

        $form->addText('part', 'Part:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE)
            ->setHtmlAttribute('min', 1)
            ->setHtmlAttribute('max', 2);

        $form->addText('startingCapital', 'Starting Capital:')
            ->setType('number')
            ->setNullable();

        $form->addText('estimatedCost', 'Estimated Cost:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('actualCost', 'Actual Cost:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addText('finalBalance', 'Final Balance:')
            ->setType('number')
            ->setRequired(self::REQUIRED_MESSAGE);

        $form->addSubmit('submit', 'Save');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess, $budget): void {
            if ($budget === null) {
                $budget = new Buget();
            }

            $budget->year = (int) $values->year;
            $budget->semester = (int) $values->semester;
            $budget->part = (int) $values->part;
            $budget->startingCapital = $values->startingCapital !== null ? (int) $values->startingCapital : null;
            $budget->estimatedCost = (int) $values->estimatedCost;
            $budget->actualCost = (int) $values->actualCost;
            $budget->finalBalance = (int) $values->finalBalance;

            $this->budgetRepository->update($budget);

            $onSuccess($budget);
        };

        return $form;
    }
}
