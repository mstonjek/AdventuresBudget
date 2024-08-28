<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use App\Model\Entity\DepartmentEnum;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'budget')]
class Budget
{
    #[ORM\Id]
    #[ORM\Column(name: 'budget_id', type: 'uuid_binary', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    public string $budgetId;

    #[ORM\Column(name: 'year', type: "integer", length: 4)]
    public int $year;

    #[ORM\Column(name: 'semester', type: "integer", length: 1)]
    public int $semester;

    #[ORM\Column(name: 'part', type: 'integer', length: 1)]
    public int $part;

    #[ORM\Column(name: 'starting_capital', type: 'integer', nullable: true)]
    public int $startingCapital;

    #[ORM\Column(name: 'estimated_cost', type: 'integer')]
    public int $estimatedCost;

    #[ORM\Column(name: 'actual_cost', type: 'integer')]
    public int $actualCost;

    #[ORM\Column(name: 'final_balance', type: 'integer')]
    public int $finalBalance;

    #[ORM\OneToMany(mappedBy: 'budget', targetEntity: Adventure::class)]
    public Collection $adventures;

    public function __construct(){
        $this->adventures = new ArrayCollection();
    }

}