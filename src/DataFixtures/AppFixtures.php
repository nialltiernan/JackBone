<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $user = (new User())
             ->setEmail('nialltiernan93@gmail.com')
             ->setUsername('nelly')
             ->setCreatedAt(new DateTimeImmutable())
         ;

         $manager->persist($user);
         $manager->flush();
    }
}
