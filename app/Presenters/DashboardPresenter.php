<?php

namespace App\Presenters;

use Nette\Application\UI\Presenter;
use App\Model\Entity;
use App\Repository\BudgetRepository;

class DashboardPresenter extends Presenter
{
    private ?array $yearBudgets = null;
    private int $currentYear;

    public function __construct(
        private readonly BudgetRepository $budgetRepository,
    ) {
    }

    public function renderDefault(): void {
        $budgetInfo = $this->budgetRepository->getYearBudgets();
        $this->yearBudgets = $budgetInfo["yearBudgets"];
        $this->currentYear = $budgetInfo["currentYear"];

        $this->template->currentYear = $this->currentYear;
        $this->template->yearBudgets = $budgetInfo["yearBudgets"];

    }

}