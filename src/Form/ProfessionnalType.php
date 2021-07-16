<?php

namespace App\Form;

use App\Entity\Professionnal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProfessionnalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('job', TextType::class, ['label' => 'Service'])
            ->add('resume', TextareaType::class, [
                'label' => "À votre sujet",
                'attr' => [
                    'placeholder' => 'Décrivez-vous',
                    'cols' => '10',
                    'rows' => '7'
                ],
            ])
            ->add('profilPhoto', FileType::class, [
                'label' => 'Image Principale',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '100k',
                    ])
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Professionnal::class
        ]);
    }
}
