<?php

namespace App\Form;

use App\Entity\Family;
use App\Entity\Student;
use App\Enum\GenreEnum;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentType extends AbstractType
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
                    'placeholder' => 'Enter Le nom de la famille de l\'étudiant',
                    'class' => 'form-control',
                ],
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrer prénon de l\'étudiant',
                    'class' => 'form-control',
                ],
            ])
            ->add('birthDate', null, [
                'widget' => 'single_text',
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
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
                'label' => 'Enregistrer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
