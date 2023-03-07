<?php

namespace App\Utils;

use App\Repository\ImagesRepository;


class Utils {

    public static function allCateg($repository)
    {
        return $repository->findAll();
    }

    public static function imageProfil($user ,ImagesRepository $imagesRepository)
    {
        if ($user) {
            $prestataire = $user->getPrestataire();
            if ($prestataire) {
                $prestataireId = $prestataire->getId();
                $image = $imagesRepository->findOneBy(['prestataire' => $prestataireId]);

                // var_dump($prestataireId, $image);
                // faire quelque chose avec $image
                if ($image) {
                    return $imageProfile = $image->getImage();
                    // faire quelque chose avec $nom
                }
            }
        }

        return false;
    }

    public static function getImage($user, ImagesRepository $repository)
    {
        if ($user) {
            // On cherche a savoir si c'est un internaute ou prestataire pour recup l'Id
            $typeUtilisateur = $user->getTypeUtilisateur();
            $methodName = 'get' . $typeUtilisateur;
            $utilisateur = call_user_func([$user, $methodName]);
            $id = $utilisateur->getId();

            // On récupère l'image
            $image = $repository->findOneBy([strtolower($typeUtilisateur) => $id]);

            return $image;
        }
    }
}
