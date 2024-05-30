<?php

namespace App\Form;

use App\Entity\Users\User;
use App\Enum\RoleEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Nom',
            ])
            ->add('firstName', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prénom',
            ])
            ->add('email', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Email',
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Admin' => RoleEnum::ROLE_ADMIN->value,
                    'Editeur' => RoleEnum::ROLE_EDITOR->value,
                    'Comptable' => RoleEnum::ROLE_ACCOUNTANT->value,
                    'Enseignant' => RoleEnum::ROLE_TEACHER->value,
                ],
                'attr' => ['class' => 'form-control'],
                'label' => 'Role',
            ])
            ->add('isVerified', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
                'attr' => [
                    'class' => 'custom-control-input',
                    'id' => 'customSwitch1',
                ],
                'label_attr' => [
                    'class' => 'custom-control-label',
                    'for' => 'customSwitch1',
                ],
            ])
        ->add('submit', SubmitType::class, [
            'attr' => [
                'class' => 'btn btn-primary',
            ],
            'label' => 'Enregistrer',
        ])
        ;
        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                fn ($rolesAsArray) => count($rolesAsArray) ? $rolesAsArray[0] : null,
                fn ($rolesAsString) => [$rolesAsString]
            ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
