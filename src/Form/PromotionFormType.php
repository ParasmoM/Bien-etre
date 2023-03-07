<?php

namespace App\Form;

use App\Entity\Promotion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PromotionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('description')
            ->add('pdf', FileType::class, [
                'label' => 'Exporter un PDF',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'Titre'
                ]
            ])
            ->add('debut')
            ->add('fin')
            ->add('afficheDe')
            ->add('afficheJusque')
            ->add('categorie')
            ->add('prestataires')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Promotion::class,
        ]);
    }
}
