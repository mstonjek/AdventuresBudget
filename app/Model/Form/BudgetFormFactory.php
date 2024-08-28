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

        $form->addSubmit('submit', 'Save');

        $form->onSuccess[] = function (Form $form, \stdClass $values) use ($onSuccess, $budget): void {
            if ($budget === null) {
                $budget = new Budget();
            }

            $budget->year = (int) $values->year;
            $budget->semester = (int) $values->semester;
            $budget->part = (int) $values->part;
            $budget->startingCapital = $values->startingCapital !== null ? (int) $values->startingCapital : 0;
            $budget->estimatedCost = 0;
            $budget->actualCost = 0;
            $budget->finalBalance = 0;

            $this->budgetRepository->update($budget);

            $onSuccess($budget);
        };

        return $form;
    }
}
