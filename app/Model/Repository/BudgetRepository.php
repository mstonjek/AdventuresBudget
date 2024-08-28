<?php

namespace App\Repository;

use App\Model\Entity\Budget;
use Doctrine\ORM\EntityManagerInterface;

class BudgetRepository extends BaseRepository
{

    public function __construct(EntityManagerInterface $entityManager) {
        parent::__construct($entityManager, Budget::class);
    }

    public function getYearBudgets(): array {
        $currentYear = (int)date('Y');

        return [
          "currentYear" => $currentYear,
          "yearBudgets" => $this->getRepository()->findBy(["year" => $currentYear]),
        ];
    }
}