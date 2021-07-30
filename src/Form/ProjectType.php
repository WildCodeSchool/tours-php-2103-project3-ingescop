<?php

namespace App\Form;

use App\Entity\Project;
use App\Entity\Professionnal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'Nom'])
            ->add('note', ChoiceType::class, [
                'choices' => [0, 1, 2, 3, 4, 5]
            ])
            ->add('place', TextType::class, ['label' => 'Lieu'])
            ->add('client', TextType::class)
            ->add('missionIngescop', TextType::class)
            ->add('budget', TextType::class)
            ->add('calendar', TextType::class, ['label' => 'Calendrier'])
            ->add('workInProgress', ChoiceType::class, [
                'choices' => ['En études' => 'En études','En travaux' => 'En travaux', 'Livré' => 'Livré'],
                'label' => "État du projet"
            ])
            ->add('strongPoints', TextareaType::class, [
                'label' => "Points forts",
                'attr' => [
                    'placeholder' => 'Mettre un # entre chaque point fort',
                    'cols' => '10',
                    'rows' => '7'
                ],
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'En bref',
                'attr' => [
                    'placeholder' => 'Description du projet',
                    'cols' => '10',
                    'rows' => '7'
                ],
            ])
            ->add('mainPhoto', FileType::class, [
                'label' => 'Image Principale',
                'mapped' => false,
                'required' => $options['main_photo_required'],
                'constraints' => [
                    new Image([
                        'maxSize' => '200k',
                    ])
                ]
            ])
            ->add('images', FileType::class, [
                'label' => 'Images',
                'mapped' => false,
                'multiple' => true,
                'required' => false,
                'constraints' => [
                    new All([
                        new Image([
                            'maxSize' => '200k',
                        ])
                    ])
                ]
            ])
            ->add('owner', EntityType::class, [
                'class' => Professionnal::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'label' => 'Professionnels associés au projet'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
            'main_photo_required' => false
        ]);

        $resolver->setAllowedTypes('main_photo_required', 'bool');
    }
}
