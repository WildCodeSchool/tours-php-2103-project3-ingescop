<?php

namespace App\Form;

use App\FormData\PasswordData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
                ->add('oldPassword', PasswordType::class, [
                    'attr' => ['placeholder' => 'Ancien mot de passe']
                ])
                ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => ['label' => false,
                                        'attr' => ['placeholder' => 'Nouveau mot de passe'
                                        ]],
                    'second_options' => ['label' => false,
                                        'attr' => ['placeholder' => 'Nouveau mot de passe'
                                        ]],
                    'invalid_message' => 'Les deux nouveaux mots de passe doivent être identiques',
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
