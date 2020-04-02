<?php

namespace App\Form;

use App\Entity\ArticleBlog;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ArticleBlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title', TextType::class, [
                'label' => 'Titre de l\'annonce',
            ])
            ->add('Content', CKEditorType::class, [
                'label' => 'Contenu de l\'article'
            ])
            ->add('imageFile', FileType::class, [
                'required' => false,
                'label' => 'Choisir la mignature de l\'article',
                'help' => 'Cette image sera présente sur la mignature ainsi que sur l\'article'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleBlog::class,
        ]);
    }
}
