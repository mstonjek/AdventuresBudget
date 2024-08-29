<?php

namespace App\Repository;

use App\Model\Entity\Adventure;
use Doctrine\ORM\EntityManagerInterface;

class AdventureRepository extends BaseRepository
{
    public function __construct(EntityManagerInterface $entityManager) {
        parent::__construct($entityManager, Adventure::class);
    }

    public function getAll(): array
    {
        return $this->getRepository()->findBy([], ["serialNumber" => "ASC"]);
    }

    public function getCount(): int
    {
        return $this->getRepository()->count([]);
    }

    public function getDisapprovedAdventures(): array
    {
        return $this->getRepository()->findBy(["approved" => false]);
    }

}