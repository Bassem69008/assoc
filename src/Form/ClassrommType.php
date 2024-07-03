<?php

namespace App\Form;

use App\Entity\Classroom;
use App\Entity\Subject;
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

            ->add('subjects', EntityType::class, [
                'class' => Subject::class,
                'label' => 'Matières',
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => false,
                'by_reference' => false,
                'attr' => ['class' => 'form-control classroom_subjects'],
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
