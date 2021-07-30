<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, ['label' => 'nom'])
            ->add('link', TextType::class, ['label' => 'url'])
            ->add('logo', FileType::class, [
                'label' => 'Logo',
                'mapped' => false,
                'required' => $options['logo_required'],
                'data_class' => null,
                'constraints' => [
                    new Image([
                        'maxSize' => '100k',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
            'logo_required' => false
        ]);
    }
}
