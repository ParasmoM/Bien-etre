<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('email')
            // ->add('roles')
            // ->add('password')
            ->add('adressN')
            ->add('adressRue')
            // ->add('inscription')
            // ->add('typeUtilisateur')
            // ->add('essais')
            // ->add('banni')
            // ->add('isVerified')
            // ->add('internaute')
            // ->add('prestataire')
            ->add('commune')
            ->add('localite')
            ->add('codePostal')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
