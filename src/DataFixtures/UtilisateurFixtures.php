<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use App\Entity\Images;
use App\Entity\Internaute;
use App\Entity\Prestataire;
use App\Entity\Promotion;
use App\Entity\Stage;
use App\Entity\Utilisateur;
use DateTime;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UtilisateurFixtures extends Fixture
{
    private $faker;

    public function __construct(private UserPasswordHasherInterface $passwordEncoder)
    {
        $this->faker = $faker = Factory::create('fr_BE');
    }
    public function load(ObjectManager $manager): void
    {
        $this->createPrestataire(40, 'femme', $manager);
        $this->createPrestataire(40, 'homme', $manager);
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
            // Nouveau Prestataire
            $prestataire = new Prestataire();
            $prestataire->setNom($faker->lastName);
            $prestataire->setPrenom($faker->firstName($sexe));
            
            // On crée 10 services pour le prestataire
            $this->createPromotion($prestataire, $manager);

            // on crée un stage 
            $this->createStage($prestataire, $manager);

            // On l'associer une image de profil 
            $this->createImageProfil($prestataire, $sexe, $manager);

            // Nouveau Utilisateur 
            $this->createUtililisateur('Prestataire', $prestataire, $manager);
            
            $manager->flush();
        }

    }

    public function createPromotion($prestataire, $manager) {
        $faker = Factory::create('fr_BE');
        $date_actuelle = new DateTime();
        $date_plus_365 = new DateTime('+365 days');

        $categoriesRepository = $manager->getRepository(Categories::class);
        $categories = $categoriesRepository->findAll();

        // Obtenez 3 clés aléatoires
        $randomKeys = array_rand($categories, 3);

        // Récupérez les catégories correspondantes
        $randomCategories = [];
        foreach ($randomKeys as $key) {
            $randomCategories[] = $categories[$key];
        }

        $promotionsCount = [6, 3, 1]; // Nombre de fois pour chaque catégorie aléatoire
        $promoCounter = 1;

        foreach ($promotionsCount as $index => $count) {
            for ($cpt = 1; $cpt <= $count; $cpt++) {
                $promo = new Promotion();
                $promo->setNom('Service ' . $promoCounter);
                $promo->setDescription($faker->sentences(10, true));
                $promo->setDebut($date_actuelle);
                $promo->setFin($date_plus_365);
                $promo->setCategorie($randomCategories[$index]);
                $promo->addPrestataire($prestataire);
        
                $manager->persist($promo);
                $promoCounter++;
            }
        }        
    }

    public function createStage($prestataire, $manager) {
        $faker = Factory::create('fr_BE');
        $date_actuelle = new DateTime();
        $date_plus_365 = new DateTime('+365 days');

        $stage = new Stage();
        $stage->setNom('STAGE 1');
        $stage->setDescription($faker->sentences(10, true));
        $stage->setInfos($faker->sentences(4, true));
        $stage->setDebut($date_actuelle);
        $stage->setFin($date_plus_365);
        $tarif = $faker->randomFloat(2, 20, 150);
        $stage->setTarif($tarif);
        $stage->addPrestataire($prestataire);

        $manager->persist($stage);
    }

    public function createImageProfil($prestataire, $sexe, $manager) {
        $tabFemmes = [
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
        $tabHommes = [
            'Homme_Africain_01.avif',
            'Homme_Africain_02.avif',
            'Homme_Africain_03.avif',
            'Homme_Africain_04.avif',
            'Homme_Africain_05.avif',
            'Homme_Africain_06.avif',
            'Homme_Africain_07.avif',
            'Homme_Africain_08.avif',
            'Homme_Africain_09.avif',
            'Homme_Africain_10.avif',
            'Homme_Asiatique_01.avif',
            'Homme_Asiatique_02.avif',
            'Homme_Asiatique_03.avif',
            'Homme_Asiatique_04.avif',
            'Homme_Asiatique_05.avif',
            'Homme_Asiatique_06.avif',
            'Homme_Asiatique_07.avif',
            'Homme_Asiatique_08.avif',
            'Homme_Asiatique_09.avif',
            'Homme_Asiatique_10.avif',
            'Homme_Caucasien_01.avif',
            'Homme_Caucasien_02.avif',
            'Homme_Caucasien_03.avif',
            'Homme_Caucasien_04.avif',
            'Homme_Caucasien_05.avif',
            'Homme_Caucasien_06.avif',
            'Homme_Caucasien_07.avif',
            'Homme_Caucasien_08.avif',
            'Homme_Caucasien_09.avif',
            'Homme_Caucasien_10.avif',
            'Homme_Metisse_01.avif',
            'Homme_Metisse_02.avif',
            'Homme_Metisse_03.avif',
            'Homme_Metisse_04.avif',
            'Homme_Metisse_05.avif',
            'Homme_Metisse_06.avif',
            'Homme_Metisse_07.avif',
            'Homme_Metisse_08.avif',
            'Homme_Metisse_09.avif',
            'Homme_Metisse_10.avif',
        ];

        $imagesRepository = $manager->getRepository(Images::class);
        $tabImages = $imagesRepository->findAll();

        do {
            // Sélectionnez le tableau en fonction de la valeur de $type
            $selectedArray = ($sexe == 'femme') ? $tabFemmes : $tabHommes;

            // Sélectionnez une image aléatoire
            $randomImage = $this->faker->randomElement($selectedArray);
            $index = array_search($randomImage, $selectedArray);
            array_splice($tabFemmes, $index, 1);
        
            $imageExists = false;
            foreach ($tabImages as $image) {
                if ($image->getNom() === $randomImage) {
                    $imageExists = true;
                    break;
                }
            }
            // La boucle recommencera si l'image existe déjà et s'il reste des images
        } while ($imageExists && !empty($tabFemmes));
        
        // Créez et enregistrez une nouvelle entité Images
        $photo = new Images();
        $photo->setNom($randomImage);
        $photo->setPrestataire($prestataire);
        $manager->persist($photo);
    }

    public function createUtililisateur($type, $prestataire, $manager) {

        $utilisateur = new Utilisateur();
        $utilisateur->setEmail($this->faker->email);
        $utilisateur->setPassword(
            $this->passwordEncoder->hashPassword($utilisateur, 'azertyui') 
        );
        $utilisateur->setTypeUtilisateur($type);
        $utilisateur->setEssais(0);
        $utilisateur->setBanni(false);
        $utilisateur->setPrestataire($prestataire);

        $manager->persist($utilisateur);
    }
}



