<?php

namespace App\Service;

use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class StudentService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private StudentRepository $studentRepository,
    ) {
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function create(Request $request): array
    {
        $student = new Student();
        $form = $this->formFactory->create(StudentType::class, $student);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Créer et associer les étudiants
            $this->studentRepository->save($student);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function edit(Request $request, Student $student): array
    {
        $form = $this->formFactory->create(StudentType::class, $student);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Créer et associer les étudiants
            $this->studentRepository->save($student);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }
}
