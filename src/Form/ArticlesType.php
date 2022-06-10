<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Articles;
use App\Entity\Categories;
use Symfony\Component\Form\AbstractType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nameArticles')
            ->add('resumeArticles', CKEditorType::class)

            ->add('contenuArticles', CKEditorType::class)
            ->add('categories', EntityType::class, [
                'class' => Categories::class,
                'choice_label' => 'nameCategories',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nameUser',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
