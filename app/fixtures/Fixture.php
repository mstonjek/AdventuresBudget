<?php

namespace App\fixtures;

use App\Model\Entity\DepartmentEnum;
use Doctrine\Persistence\ObjectManager;
use App\Model\Entity\Adventure;
use Doctrine\Common\DataFixtures\FixtureInterface;

class Fixture implements FixtureInterface
{
    public function __construct(
        //        private Factory $factory
    ) {
    }
    /**
     * Load data fixtures with the passed ObjectManager.
     */
    public function load(ObjectManager $manager): void
    {
        $adventure = new Adventure();
        $adventure->adventureName = "Fluffy Trip";
        $adventure->serialNumber = 1;
        $adventure->adventureDate = new \DateTime('2024-01-01');
        $adventure->orderNumber = 'ORD1';
        $adventure->participantsCount = 5;
        $adventure->providerName = 'Marek Ztracený';
        $adventure->coordinatorName = 'Martin Dejdar';
        $adventure->estimatedCost = 100.50;
        $adventure->actualCost = 95.00;
        $adventure->department = DepartmentEnum::BEAVERS;


        $manager->persist($adventure);
        $manager->flush();
    }
}
