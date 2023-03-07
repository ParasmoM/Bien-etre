<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Prestataire;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PrestataireFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $faker = Factory::create('fr_BE');

        // for($user = 1; $user <= 25; $user++) {
        //     $prestataire = new Prestataire();
        //     $prestataire->setNom($faker->lastName);
        //     $prestataire->setPrenom($faker->firstName('female'));

        //     $manager->persist($prestataire);
        // }
        
        // for($user = 1; $user <= 25; $user++) {
        //     $prestataire = new Prestataire();
        //     $prestataire->setNom($faker->lastName);
        //     $prestataire->setPrenom($faker->firstName('male'));

        //     $manager->persist($prestataire);
        // }
        
        // $manager->flush();
    }
}
