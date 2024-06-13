<?php

namespace App\Form;

use App\Entity\Teacher;
use App\Enum\GenreEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeacherType extends AbstractType
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
                    'placeholder' => 'Entrer votre nom ',
                    'class' => 'form-control',
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom ',
                'attr' => [
                    'placeholder' => 'Entrer votre Prénom ',
                    'class' => 'form-control',
                ],
            ])
            ->add('email', TextType::class, [
                'label' => 'Email ',
                'attr' => [
                    'placeholder' => 'Entrer Votre Email ',
                    'class' => 'form-control',
                ],
            ])
            ->add('phone', TextType::class, [
                'label' => 'N° de téléphone',
                'attr' => [
                    'placeholder' => 'Entrer votre numéro de téléphone',
                    'class' => 'form-control',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
