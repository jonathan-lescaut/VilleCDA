<?php

namespace App\Form;

use App\Entity\Presentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PresentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titrePresentation');

            $tabImg = ['logoPresentation', 'imgPresentation', 'imgPresentation1', 'imgPresentation2', 'imgPresentation3', 'imgPresentation4'];
            foreach ($tabImg as $key) {       
                $builder->add($key, FileType::class, [
                    'label' => $key,
                    'mapped' => false,
                    'required' => false,
                    'constraints' => [
                        new File([
                            'maxSize' => '1024k',
                            'mimeTypes' => [
                                'image/*',
                            ],
                            'mimeTypesMessage' => 'Veuillez entrer un format de document
                    valide',
                        ])
                    ],
                ]);
            }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Presentation::class,
        ]);
    }
}
