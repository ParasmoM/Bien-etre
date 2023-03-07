<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/services', name: 'services_')]
class ServicesController extends AbstractController
{
    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show($id, Categories $categorie,CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);
        
        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        
        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);
        // dd($categorie->getImages());
        return $this->render('services/show.html.twig', compact(
            'categories', 
            'categorie',
            'image'
        ));
    }
}
