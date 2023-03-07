<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Images;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ImagesFixtures extends Fixture
{
    private $tabCategories = [
        'Massage' => 'Massage.avif',
        'Nutritionniste' => 'Nutritionniste.avif',
        'Yoga' => 'Yoga.avif',
        'Esthéticienne' => 'Esthéticienne.avif',
        'Coach sportive' => 'Coach sportive.avif',
    ];

    public function load(ObjectManager $manager): void
    {
        $this->imageCateg($this->tabCategories, $manager);
    }

    public function imageCateg($tab, $manager) {
        foreach($tab as $category => $imageNom) {

            $imageCateg = new Images();
            $categoriesRepository = $manager->getRepository(Categories::class);
    
            $categ = $categoriesRepository->findOneBy(['nom' => $category]);
    
            $imageCateg->setCategorie($categ);
            $imageCateg->setNom($imageNom);
    
            $manager->persist($imageCateg);
            $manager->flush();

        }
    }
}
