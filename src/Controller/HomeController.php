<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);
        return $this->render('home/index.html.twig', compact(
            'categories',
            'image',
        ));
    }
}
