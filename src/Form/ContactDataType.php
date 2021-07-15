<?php

namespace App\Form;

use App\FormData\ContactData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'label' => 'Nom',
                'attr' => ['placeholder' => 'Nom'],
                ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['placeholder' => 'Prénom'],
                ])
            ->add('phoneNumber', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['placeholder' => 'Numéro de téléphone'],
                ])
            ->add('emailAddress', EmailType::class, [
                'label' => 'E-mail',
                'attr' => ['placeholder' => 'E-mail'],
                ])
            ->add('message', TextareaType::class, [
                'label' => 'Tes motivations',
                'attr' => ['placeholder' => 'Sois direct et précis, on adore !'],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactData::class
        ]);
    }
}
