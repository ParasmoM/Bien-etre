<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Repository\PrestataireRepository;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository, PrestataireRepository $prestataireRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $prestataires = $prestataireRepository->findBy([], ['id' => 'DESC'], 4);

        $imagesBanner = $imagesRepository->findBy(['categorie' => null, 'internaute' => null, 'prestataire' => null]);

        return $this->render('home/index.html.twig', compact(
            'categories',
            'image',
            'prestataires',
            'imagesBanner',
        ));
    }
}
