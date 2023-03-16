<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    private $tabCategories = [
        'Massage',
        'Nutritionniste',
        'Yoga',
        'Esthéticienne',
        'Coach sportive',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach ($this->tabCategories as $category) {
            $this->createCategories($category, $manager);
        }

        $manager->flush();
        
        $categoriesRepository = $manager->getRepository(Categories::class);
        $categ = $categoriesRepository->findAll();

        $randomIndex = array_rand($categ);
        $randomCategory = $categ[$randomIndex];

        $randomCategory->setEnAvant(true);
        $manager->persist($randomCategory);
        $manager->flush();
    }

    public function createCategories($nom, ObjectManager $manager) {
        $faker = Factory::create('fr_BE');
        
        $categories = new Categories();
        $categories->setNom($nom);
        $categories->setDescription($faker->sentences(10, true));
        $manager->persist($categories);
    }
}
