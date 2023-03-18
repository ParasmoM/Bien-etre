<?php

namespace App\Controller;

use App\Entity\Prestataire;
use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Repository\PrestataireRepository;
use App\Utils\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

#[Route('/prestataire', name: 'prestataire_')]
class PrestataireController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(Request $request, CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository, PrestataireRepository $prestataireRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        // Récupérez le numéro de la page à partir de la requête, utilisez 1 par défaut si aucune page n'est fournie
        $page = $request->query->get('page', 1);

        // On récupère les filtres 
        $filters = $request->get("category");

        if($filters != null) {
            // return new JsonResponse($filters);
        }
        if($filters) {
            // dd('ok');
        }
        // dd($filters);
        // On récupère tout les prestataires paginer
        $prestataires = $prestataireRepository->findPrestatairesPaginated($page, 8, $filters);
        // On vérifier si on a une requête ajax 
        if($request->get('ajax')) {
            return new JsonResponse([
                'content' => $this->renderView('_partials/_prestataire_card.html.twig', compact(
                    'categories',
                    'image',
                    'prestataires',
                ))
            ]);            
        }
        // dd($prestataires);
        return $this->render('prestataire/index.html.twig', compact(
            'categories',
            'image',
            'prestataires',
        ));
    }

    #[Route('/{id}', name: 'show')]
    public function show(Prestataire $prestataire, CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository, PrestataireRepository $prestataireRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $data = [
            'id' => 1,
            'nom' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
        ];

        $imagesBanner = $imagesRepository->findBy(['categorie' => null, 'internaute' => null, 'prestataire' => null]);
        
        return $this->render('prestataire/show.html.twig', compact(
            'categories',
            'image',
            'prestataire',
            'imagesBanner',
            'data',

        ));
    }

    #[Route('/test', name: 'test', methods: ['GET', 'POST'])]
    public function test()
    {
        $data = [
            'id' => 1,
            'nom' => 'Jean Dupont',
            'email' => 'jean.dupont@example.com',
        ];

        dd($data);
        return $this->json($data);
    
    }
}
