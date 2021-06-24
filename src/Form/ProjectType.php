<?php

namespace App\Form;

use DateTimeInterface;
use App\Entity\Project;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('note', ChoiceType::class, [
                'choices' => [0, 1, 2, 3, 4, 5]
            ])
            ->add('place', TextType::class)
            ->add('client', TextType::class)
            ->add('missionIngescop', TextType::class)
            ->add('budget', TextType::class)
            ->add('calendar', TextType::class)
            ->add('workInProgress', ChoiceType::class, [
                'choices' => ['En études' => 'En études','En travaux' => 'En travaux', 'Livré' => 'Livré']
            ])
            ->add('strongPoints', TextType::class)
            ->add('resume', TextType::class)
            ->add('photoOne', TextType::class)
            ->add('photoTwo', TextType::class)
            ->add('photoThree', TextType::class)
            ->add('owner', null, ['choice_label' => 'name'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
