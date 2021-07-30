<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class AdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => ['placeholder' => 'Identifiant']
            ])
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => ['label' => false,
                                    'attr' => ['placeholder' => 'Nouveau mot de passe'
                                    ]],
                'second_options' => ['label' => false,
                                    'attr' => ['placeholder' => 'Nouveau mot de passe'
                                    ]],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'required' => true,
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
