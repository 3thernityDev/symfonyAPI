<?php

namespace App\DataFixtures;

use App\Factory\BankAccountFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        BankAccountFactory::createMany(10);

        $manager->flush();
    }
}
