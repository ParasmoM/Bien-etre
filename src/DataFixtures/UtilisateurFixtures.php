<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Internaute;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Entity\Utilisateur;
use DateTime;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    private $tabFemmes = [
        'Femme_Africaine_01.avif',
        'Femme_Africaine_02.avif',
        'Femme_Africaine_03.avif',
        'Femme_Africaine_04.avif',
        'Femme_Africaine_05.avif',
        'Femme_Africaine_06.avif',
        'Femme_Africaine_07.avif',
        'Femme_Africaine_08.avif',
        'Femme_Africaine_09.avif',
        'Femme_Africaine_10.avif',
        'Femme_Asiatique_01.avif',
        'Femme_Asiatique_02.avif',
        'Femme_Asiatique_03.avif',
        'Femme_Asiatique_04.avif',
        'Femme_Asiatique_05.avif',
        'Femme_Asiatique_06.avif',
        'Femme_Asiatique_07.avif',
        'Femme_Asiatique_08.avif',
        'Femme_Asiatique_09.avif',
        'Femme_Asiatique_10.avif',
        'Femme_Caucasien_01.avif',
        'Femme_Caucasien_02.avif',
        'Femme_Caucasien_03.avif',
        'Femme_Caucasien_04.avif',
        'Femme_Caucasien_05.avif',
        'Femme_Caucasien_06.avif',
        'Femme_Caucasien_07.avif',
        'Femme_Caucasien_08.avif',
        'Femme_Caucasien_09.avif',
        'Femme_Caucasien_10.avif',
        'Femme_Metisse_01.avif',
        'Femme_Metisse_02.avif',
        'Femme_Metisse_03.avif',
        'Femme_Metisse_04.avif',
        'Femme_Metisse_05.avif',
        'Femme_Metisse_06.avif',
        'Femme_Metisse_07.avif',
        'Femme_Metisse_08.avif',
        'Femme_Metisse_09.avif',
        'Femme_Metisse_10.avif',
    ];
    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {}
    public function load(ObjectManager $manager): void
    {
        // $this->createInternaute(20, 'female', $manager);
        $this->createPrestataire(2, 'female', $manager);
    }

    public function createInternaute($nbr, $sexe, $manager) {
        $faker = Factory::create('fr_BE');

        for($user = 1; $user <= $nbr; $user++) {
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($faker->email);
            $utilisateur->setPassword(
                $this->passwordEncoder->hashPassword($utilisateur, 'azertyui') 
            );
            $utilisateur->setTypeUtilisateur('Internaute');
            $utilisateur->setEssais(0);
            $utilisateur->setBanni(false);

            $internaute = new Internaute();
            $internaute->setNom($faker->lastName);
            $internaute->setPrenom($faker->firstName($sexe));
            
            $photo = new Images();
            $nomPhoto = $faker->randomElement($this->tabFemmes);
            $index = array_search($nomPhoto, $this->tabFemmes);
            array_splice($this->tabFemmes, $index, 1);
            $photo->setNom($nomPhoto);

            $photo->setInternaute($internaute);
            $utilisateur->setInternaute($internaute);

            $manager->persist($photo);
            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
    public function createPrestataire($nbr, $sexe, $manager) {
        $faker = Factory::create('fr_BE');

        for($user = 1; $user <= $nbr; $user++) {
            // Nouveau Utilisateur 
            $utilisateur = new Utilisateur();
            $utilisateur->setEmail($faker->email);
            $utilisateur->setPassword(
                $this->passwordEncoder->hashPassword($utilisateur, 'azertyui') 
            );
            $utilisateur->setTypeUtilisateur('Prestataire');
            $utilisateur->setEssais(0);
            $utilisateur->setBanni(false);

            // Nouveau Prestataire
            $prestataire = new Prestataire();
            $prestataire->setNom($faker->lastName);
            $prestataire->setPrenom($faker->firstName($sexe));
            
            // On l'associer une image de profil 
            $photo = new Images();
            $nomPhoto = $faker->randomElement($this->tabFemmes);
            $index = array_search($nomPhoto, $this->tabFemmes);
            array_splice($this->tabFemmes, $index, 1);
            $photo->setNom($nomPhoto);

            // On l'associe une ou des promo(s) et stage(s) 
            $promo = new Promotion();
            $promo->setNom($faker->sentence(2, true));
            $promo->setDescription($faker->sentences(10, true));
            $date_actuelle = new DateTime();
            $date_plus_7 = new DateTime('+7 days');
            $date_plus_365 = new DateTime('+365 days');
            $promo->setDebut($date_actuelle);
            $promo->setFin($date_plus_365);
            $promo->setAfficheDe($date_actuelle);
            $promo->setAfficheJusque($date_plus_7);
            $promo->addPrestataire($prestataire);

            $categoriesRepository = $manager->getRepository(Categories::class);
            $categories = $categoriesRepository->findAll();
            $names = [];

            foreach ($categories as $category) {
                $name = $category->getNom();
                $names[] = $name;
            }

            $promo->setCategorie($faker->randomElement($categories));



            // dump($categories);
            $photo->setPrestataire($prestataire);
            $utilisateur->setPrestataire($prestataire);

            $manager->persist($photo);
            $manager->persist($utilisateur);
        }

        $manager->flush();
    }
}
