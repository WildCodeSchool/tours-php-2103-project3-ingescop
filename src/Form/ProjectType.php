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

class ProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('note', IntegerType::class)
            ->add('place', CollectionType::class)
            ->add('client', TextType::class)
            ->add('missionIngescop', TextType::class)
            ->add('budget', TextType::class)
            ->add('calendar', TextType::class)
            ->add('workInProgress', TextType::class)
            ->add('resume', TextType::class)
            ->add('photoOne', TextType::class)
            ->add('strongPoints', TextType::class)
            ->add('photoTwo', TextType::class)
            ->add('photoThree', TextType::class)
            ->add('owner', CollectionType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Project::class,
        ]);
    }
}
