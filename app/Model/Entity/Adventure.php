<?php

namespace App\Model\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[ORM\Entity]
#[ORM\Table(name: 'adventure')]
class Adventure
{
    #[ORM\Id]
    #[ORM\Column(name: 'user_id', type: 'uuid_binary', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidGenerator::class)]
    public string $adventureId;

    #[ORM\Column(name: 'serial_number', type: 'integer', unique: true)]
    public int $serialNumber;

    #[ORM\Column(name: 'order_number', type: 'string', length: 255, nullable: true)]
    public ?string $orderNumber = null;

    #[ORM\Column(name: 'name', type: 'string', length: 255)]
    public string $adventureName;

    #[ORM\Column(name: 'date', type: 'datetime')]
    public \DateTime $adventureDate;

    #[ORM\Column(name: 'participants_count', type: 'integer')]
    public int $participantsCount;

    #[ORM\Column(name: 'provider_name', type: 'string', length: 255)]
    public string $providerName;

    #[ORM\Column(name: 'coordinator_name', type: 'string', length: 255)]
    public string $coordinatorName;

    

}