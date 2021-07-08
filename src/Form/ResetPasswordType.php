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
                ->add('oldPassword', PasswordType::class)
                ->add('Password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => ['label' => 'Password'],
                    'second_options' => ['label' => 'Repeat Password'],
                    'invalid_message' => 'Les deux mots de passe doivent être identiques',
                    'options' => array(
                        'attr' => array(
                            'class' => 'password-field'
                        )
                    ),
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
