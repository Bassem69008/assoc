<?php

namespace App\Form;

use App\Entity\Family;
use App\Entity\ParentEntity;
use App\Enum\GenreEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    GenreEnum::MALE_GENRE->value => 'H',
                    GenreEnum::FEMALE_GENRE->value => 'F',
                ],
                'label' => 'Genre',
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom ',
                'attr' => [
                    'placeholder' => 'Entrer Le nom ',
                    'class' => 'form-control',
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom ',
                'attr' => [
                    'placeholder' => 'Entrer Le prénom',
                    'class' => 'form-control',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email ',
                'attr' => [
                    'placeholder' => 'Entrer Email',
                    'class' => 'form-control',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone ',
                'attr' => [
                    'placeholder' => 'Entrer Numéro de téléphone',
                    'class' => 'form-control',
                ],
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'label' => 'Famille',
                'choice_label' => function (Family $family) {
                    return $family->getFamilyName().' - '.$family->getEmail();
                },
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParentEntity::class,
        ]);
    }
}
