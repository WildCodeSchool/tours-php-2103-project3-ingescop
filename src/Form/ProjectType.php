<?php

namespace App\Form;

use App\Entity\Professionnal;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;

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
            ->add('strongPoints', TextType::class, ['label' => 'Points forts'])
            ->add('resume', TextType::class, ['label' => 'En bref'])
            ->add('photoOne', FileType::class, [
                'label' => 'Photos',
                'mapped' => false,
                'multiple' => false,
                'required' => true,
                'constraints' => [
                    new Image([
                        'maxSize' => '2500k',
                    ])
                ]
            ])
            ->add('photoTwo', FileType::class, [
                'label' => 'Photo secondaire',
                'mapped' => false,
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2500k',
                    ])
                ]
            ])
            ->add('photoThree', FileType::class, [
                'label' => 'Photo secondaire',
                'mapped' => false,
                'multiple' => false,
                'required' => false,
                'constraints' => [
                    new Image([
                        'maxSize' => '2500k',
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
        ]);
    }
}
