<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Annonce;
use App\Entity\Category;
use App\Entity\Departement;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AnnonceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Entrez le titre votre annonce'
                ]
            ])
            ->add('Content', CKEditorType::class, [
                'label' => 'Description'
            ])
            ->add('Quantity', TextType::class, [
                'label' => 'Quantité (en Kg)',
                'attr' => [
                    'placeholder' => 'Entrez la quantité que vous voulez echanger (en Kg)'
                ]
            ])
            ->add('Location', EntityType::class, [
                'choice_label'=> 'Name',
                'class'=> Departement::class,
                'label'=>'Département'
            ])
            ->add('Type', EntityType::class, [
                'choice_label'=> 'Type',
                'class'=> Category::class,
                'label'=>'Type de produit'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Choisir l\'image de l\'annonce',
                'help' => 'Cette image sera présente sur la mignature ainsi que sur l\'annonce (Taille max : 2Mo)',
                'attr' => [
                    'placeholder' => 'Importer l\'image de votre ordinateur'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
