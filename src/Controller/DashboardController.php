<?php

namespace App\Controller;

use App\Entity\Promotion;
use App\Form\PromotionFormType;
use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Repository\PromotionRepository;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dashboard', name: 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('/{type}', name: 'index')]
    public function index($type, Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        
        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $type = ($type == 'service') ? 'promotion' : $type;
        $repositoryName = 'App\Entity\\' . ucfirst($type);
        $repository = $entityManager->getRepository($repositoryName);
        $results = $repository->findAll();  

        return $this->render('dashboard/index.html.twig', compact(
            'categories',
            'image',
            'results'
        ));
    }

    #[Route('/form/{type}', name: 'form', methods: ['GET', 'POST'])]
    public function form($type, Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();
        
        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        // On instance le service ou le stage 
        $type = ($type == 'service') ? 'promotion' : $type;
        $class = 'App\Entity\\' . ucfirst($type);
        $class = new $class;

        $newServiceOrStage = 'App\Form\\' . ucfirst($type) . 'FormType';
        $form = $this->createForm($newServiceOrStage, $class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($class);
            $entityManager->flush();
            
            return $this->redirectToRoute('dashboard_index', ['type' => $type]);
        }

        return $this->render('dashboard/form.html.twig', compact(
            'categories',
            'image',
            'type',
            'form'
        ));
    }

    #[Route('/service/{id}', name: 'show', methods: ['GET', 'POST'])]
    public function show($id, Promotion $promotion,CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $type = 'service';
        return $this->render('dashboard/show.html.twig', compact(
            'categories',
            'image',
            'promotion',
            'type'
        ));
    }

    #[Route('/service/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit($id, Request $request, Promotion $promotion, PromotionRepository $promotionRepository, CategoriesRepository $categorieRepository, ImagesRepository $imagesRepository): Response
    {
        // On recupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $form = $this->createForm(PromotionFormType::class, $promotion);
        $form->handleRequest($request); 
        if ($form->isSubmitted() && $form->isValid()) {
            $promotionRepository->save($promotion, true);

            return $this->redirectToRoute('dashboard_index', ['type' => 'service'], Response::HTTP_SEE_OTHER);
        }
        return $this->render('dashboard/edit.html.twig', compact(
            'categories',
            'image',
            'form',
            // 'promotion',
        ));
    }

    #[Route('/service/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Promotion $promotion, PromotionRepository $promotionRepository): Response
    {
        $form = $this->createForm(PromotionFormType::class, $promotion);
        $form->handleRequest($request); 
        
        if ($this->isCsrfTokenValid('delete'.$promotion->getId(), $request->request->get('_token'))) {
            dd('ici');
            $promotionRepository->remove($promotion, true);
        }
        return $this->redirectToRoute('dashboard_index', ['type' => 'service'], Response::HTTP_SEE_OTHER);
    }
}
