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
            ->add('lastName', TextType::class, ['label'=>'Nom'])
            ->add('firstName', TextType::class, ['label'=>'Prénom'])
            ->add('phoneNumber', TextType::class, ['label'=>'Téléphone'])
            ->add('emailAddress', EmailType::class, ['label'=>'E-mail'])
            ->add('message', TextareaType::class, [
                'label'=>'Tes motivations',
                'attr'=>['placeholder'=>'sois direct et précis, on adore !'],
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContactData::class
        ]);
    }
}
