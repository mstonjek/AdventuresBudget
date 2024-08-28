<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use App\Model\Entity\DepartmentEnum;
use App\Model\Entity\Budget;

#[ORM\Entity]
#[ORM\Table(name: 'adventure')]
class Adventure
{
    #[ORM\Id]
    #[ORM\Column(name: 'adventure_id', type: 'uuid_binary', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    public string $adventureId;

    #[ORM\ManyToOne(targetEntity: Budget::class, inversedBy: 'budget_id')]
    #[ORM\JoinColumn(name: 'budget_id', referencedColumnName: 'budget_id')]
    public Budget $budget;

    #[ORM\Column(name: 'serial_number', type: 'integer', unique: true)]
    public int $serialNumber;

    #[ORM\Column(name: 'order_number', type: 'string', length: 255, nullable: true)]
    public ?string $orderNumber = null;

    #[ORM\Column(name: 'adventure_name', type: 'string', length: 255)]
    public string $adventureName;

    #[ORM\Column(name: 'date', type: 'datetime')]
    public \DateTime $adventureDate;

    #[ORM\Column(name: 'department', type: 'string', enumType: DepartmentEnum::class)]
    public DepartmentEnum $department = \App\Model\Entity\DepartmentEnum::BEAVERS;
    #[ORM\Column(name: 'participants_count', type: 'integer')]
    public int $participantsCount;

    #[ORM\Column(name: 'provider_name', type: 'string', length: 255)]
    public string $providerName;

    #[ORM\Column(name: 'coordinator_name', type: 'string', length: 255)]
    public string $coordinatorName;

    #[ORM\Column(name: 'estimated_cost', type: 'float')]
    public float $estimatedCost;

    #[ORM\Column(name: 'actual_cost', type: 'float', nullable: true)]
    public ?float $actualCost;

    #[ORM\Column(name: 'approved', type: 'boolean')]
    public bool $approved = false;







}