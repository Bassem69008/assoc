<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Teacher;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassrommType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('startHour', null, [
                'widget' => 'single_text',
            ])
            ->add('endHour', null, [
                'widget' => 'single_text',
            ])
            ->add('teacher', EntityType::class, [
                'class' => Teacher::class,
                'choice_label' => function (Teacher $teacher) {
                    return \sprintf('%s %s', $teacher->getFirstName(), $teacher->getLastName());
                },
                'label' => 'Enseignant',
                'attr' => ['class' => 'form-control'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Classroom::class,
        ]);
    }
}
