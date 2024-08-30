<?php

namespace App\Service;

use App\Model\Entity\Budget;
use App\Repository\BudgetRepository;

class BudgetCalculation
{
    public function  __construct(
        private readonly BudgetRepository $budgetRepository,
    ) {
    }

    public function calculateBudget(): array
    {
        $yearInfo = $this->budgetRepository->getYearBudgets();
        $yearBudgets = $yearInfo["yearBudgets"];
        $yearSum = [];


        foreach ($yearBudgets as $yearBudget) {
            $year = $yearBudget->year;

            if (!isset($yearSum["Starting Capital Sum " . $year])) {
                $yearSum["Starting Capital Sum " . $year] = 0;
            }
            if (!isset($yearSum["Estimated Cost Sum " . $year])) {
                $yearSum["Estimated Cost Sum " . $year] = 0;
            }
            if (!isset($yearSum["Actual Cost Sum " . $year])) {
                $yearSum["Actual Cost Sum " . $year] = 0;
            }

            $yearSum["Starting Capital Sum " . $year] += $yearBudget->startingCapital;
            $yearSum["Estimated Cost Sum " . $year] += $yearBudget->estimatedCost;
            $yearSum["Actual Cost Sum " . $year] += $yearBudget->actualCost;
        }

        $yearSum["Actual Cost Balance " . (string)$yearBudget->year] = $yearSum["Starting Capital Sum " . (string)$yearBudget->year] - $yearSum["Actual Cost Sum " . (string)$yearBudget->year];
        $yearSum["Estimated Cost Balance " . (string)$yearBudget->year] = $yearSum["Starting Capital Sum " . (string)$yearBudget->year] - $yearSum["Estimated Cost Sum " . (string)$yearBudget->year];

        return $yearSum;
    }


}