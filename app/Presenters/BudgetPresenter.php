<?php

namespace App\Presenters;

use App\Forms\BudgetFormFactory;
use Nette\Application\UI\Presenter;
use App\Model\Entity\Budget;
use App\Repository\BudgetRepository;
use Nette\Forms\Form;

class BudgetPresenter extends Presenter
{

    private Budget $budget;
    private array $yearBudgets;
    private int $currentYear;

    public function __construct(
        private readonly BudgetRepository $budgetRepository,
        private readonly BudgetFormFactory $budgetFormFactory
    ) {
    }

    public function actionEdit(string $budgetId): void
    {
        $budget = $this->budgetRepository->find($budgetId);
        if (!$this->budget instanceof Budget) {
            $this->flashMessage('Tento budget neexistuje!', 'alert-danger');
            $this->redirect('Dashboard:default');
        }
        $this->budget = $budget;
        $this->template->budget = $this->budget;
    }


    public function renderDefault(): void {
        $budgetInfo = $this->budgetRepository->getYearBudgets();
        $this->yearBudgets = $budgetInfo["yearBudgets"];
        $this->currentYear = $budgetInfo["currentYear"];

        $this->template->currentYear = $this->currentYear;
        $this->template->yearBudgets = $budgetInfo["yearBudgets"];


    }

    protected function createComponentEditBudgetForm(): Form
    {
        return $this->budgetFormFactory->create(
            function ($budget): void {
                $this->flashMessage("Budget byl úspěšně vytvořen", 'alert-success');
                $this->redirect('Dashboard:default');
            }, $this->budget
        );
    }

    protected function createComponentAddBudgetForm(): Form
    {
        return $this->budgetFormFactory->create(
            function ($budget): void {
                $this->flashMessage("Budget byl úspěšně upraven", 'alert-success');
                $this->redirect('Dashboard:default');
            }
        );
    }

}