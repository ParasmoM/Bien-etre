<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesFormType;
use App\Form\UtilisateurFormType;
use App\Repository\CategoriesRepository;
use App\Repository\ImagesRepository;
use App\Service\PictureService;
use App\Utils\Utils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/parametre', name: 'parametre_')]
class ParametreController extends AbstractController
{
    #[Route('/{id}', name: 'index', methods: ['GET', 'POST'])]
    public function index($id, Request $request, EntityManagerInterface $entityManager, CategoriesRepository $categorieRepository,ImagesRepository $imagesRepository, PictureService $pictureService, ParameterBagInterface $parameterBagInterface): Response
    {
        // On récupère la liste des services
        $categories = Utils::allCateg($categorieRepository);

        // Récupération de l'utilisateur connecté
        $user = $this->getUser();

        $userForm = $this->createForm(UtilisateurFormType::class, $user);
        $userForm->handleRequest($request);

        // On récupère en fonction de s’il est internaute ou prestataire 
        $methodName = 'get' . $user->getTypeUtilisateur();
        $utilisateur = call_user_func([$user, $methodName]);

        // On crée le formulaire en fonction du type de l'utilisateur 
        $type = $user->getTypeUtilisateur() . 'FormType';
        $formType = 'App\Form\\' . $type;

        $utilisateurForm = $this->createForm($formType, $utilisateur);
        $utilisateurForm->handleRequest($request);

        // On récupère l'instance image
        $image = Utils::getImage($user, $imagesRepository);

        $imagesForm = $this->createForm(ImagesFormType::class, $image);
        $imagesForm->handleRequest($request);

        /* foreach ( $user->getPrestataire()->getImages() as $item ) {
            dd($item);
        } */
        // dd($user->getPrestataire()->getImages()->toArray()[0], $image);

        if ($userForm->isSubmitted() && $userForm->isValid() || $utilisateurForm->isSubmitted() && $utilisateurForm->isValid() || $imagesForm->isSubmitted() && $imagesForm->isValid()) {
            // On récupère l'image du form
            $image = $imagesForm->get('nom')->getData();

            if($image) {
                $folder = $user->getTypeUtilisateur();
                $id = $utilisateur->getId();
                
                $verif = $imagesRepository->findOneBy(['prestataire' => $id]);

                if($verif) {
                    $oldPicture = $verif->getNom();
                    $path = $parameterBagInterface->get('image_directory') . $folder . '/' . $oldPicture;
                    if (file_exists($path)) {
                        unlink($path);
                    }

                    $fichier = $pictureService->add($image, $folder);

                    $verif->setNom($fichier);
                    $utilisateur->addImage($verif);
                } else {
                    $fichier = $pictureService->add($image, $folder);
                    $img = new Images();
                    $img->setNom($fichier);
                    $utilisateur->addImage($img);
                }
                $entityManager->persist($user);
                $entityManager->flush();
                return $this->redirectToRoute('parametre_index', ['id' => $user->getId()]);
            }
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }
        
        return $this->render('parametre/index.html.twig', compact(
            'categories',
            'userForm',
            'utilisateurForm',
            'imagesForm',
            'image',
        ));
    }
}
