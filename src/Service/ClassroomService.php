<?php

namespace App\Service;

use App\Entity\Classroom;
use App\Form\ClassrommType;
use App\Repository\ClassroomRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;

class ClassroomService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private ClassroomRepository $classroomRepository
    ) {
    }

    /**
     * @return array<string, mixed>
     */
    public function createAndEditClassroom(Request $request, ?Classroom $classroom = null): array
    {
        if (!$classroom) {
            $classroom = new Classroom();
        }
        $form = $this->formFactory->create(ClassrommType::class, $classroom);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->classroomRepository->save($classroom);

            return ['isSuccess' => true];
        }

        return ['isSuccess' => false, 'form' => $form->createView(), 'editMode' => null !== $classroom->getId()];
    }
}
