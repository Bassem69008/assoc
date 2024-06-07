<?php

namespace App\Form;

use App\Entity\Student;
use App\Enum\GenreEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CollectionStudentType extends AbstractType
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
                    'class' => 'form-control col',
                ],
                'required' => false,
            ])
            ->add('lastName', TextType::class, [
                'label' => 'Nom ',
                'attr' => [
                    'placeholder' => 'Enter Le nom de la famille de l\'étudiant',
                    'class' => 'form-control col-md-12',
                ],
                'required' => false,
            ])
            ->add('firstName', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'placeholder' => 'Entrer prénon de l\'étudiant',
                    'class' => 'form-control col ',
                ],
                'required' => false,
            ])
            ->add('birthDate', null, [
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control col ',
                ],
                'required' => false,
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
