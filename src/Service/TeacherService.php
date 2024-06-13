<?php

namespace App\Service;

use App\Entity\Teacher;
use App\Form\TeacherType;
use App\Repository\TeacherRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class TeacherService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private TeacherRepository $teacherRepository
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function createAndEditTeacher(Request $request, ?Teacher $teacher = null): array
    {
        if (!$teacher) {
            $teacher = new Teacher();
        }
        $form = $this->formFactory->create(TeacherType::class, $teacher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->teacherRepository->save($teacher);

            return ['isSuccess' => true];
        }

        return ['isSuccess' => false, 'form' => $form->createView(), 'editMode' => null !== $teacher->getId()];
    }
}
