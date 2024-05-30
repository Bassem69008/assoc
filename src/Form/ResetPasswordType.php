<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Users\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ResetPasswordType extends AbstractType
{
    /**
     * Builds the form.
     *
     * This method is called for each type in the hierarchy starting from the
     * top most type. Type extensions can further modify the form.
     *
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /*
         * 'hash_property_path' option tells the form that the password will be hashed
         * using the PasswordHasher component and stored in the property defined (here 'password').
         * https://symfony.com/doc/current/reference/forms/types/password.html#hash-property-path
         */
        $builder
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'first_options' => [
                    'label' => 'Nouveau Mot de passe',
                    'hash_property_path' => 'password',
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'constraints' => [
                    new Regex(
                        [
                            'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,15}$/",
                            'message' => 'security.password.requirements',
                        ]
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
