<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Internaute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InternauteFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create('fr_BE');

        // for($user = 1; $user <= 25; $user++) {
        //     $internaute = new Internaute();
        //     $internaute->setNom($faker->lastName);
        //     $internaute->setPrenom($faker->firstName('female'));

        //     $manager->persist($internaute);
        // }
        
        // for($user = 1; $user <= 25; $user++) {
        //     $internaute = new Internaute();
        //     $internaute->setNom($faker->lastName);
        //     $internaute->setPrenom($faker->firstName('male'));

        //     $manager->persist($internaute);
        // }
        
        // $manager->flush();
    }
}
