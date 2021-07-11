<?php

namespace App\Form;

use App\FormData\PasswordData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\HttpFoundation\Response;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('oldPassword', PasswordType::class, [
                    'label' => 'Ancien mot de passe',
                ])
                ->add('Password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Nouveau mot de passe',
                                        'label_attr' => ['class' => 'text-5xl text-gray-600']],
                    'second_options' => ['label' => 'Retapez le nouveau mot de passe',
                                         'label_attr' => ['class' => 'text-5xl text-gray-600']],
                    'invalid_message' => 'Les deux mots de passe doivent être identiques',
                    'options' => [
                        'attr' => [
                            'class' => 'shadow appearance-none border-yellow-200 h-15 w-32 p-4 border-4 w-full'
                        ]
                    ],
                    'required' => true,
                ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults(array(
            //mettre le nouveau formulaire
            'data_class' => PasswordData::class,
            'csrf_token_id' => 'change_password',
        ));
    }
}
