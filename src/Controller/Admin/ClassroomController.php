<?php

namespace App\Controller\Admin;

use App\Entity\Classroom;
use App\Repository\ClassroomRepository;
use App\Service\ClassroomService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/classroom', name: 'classroom_')]
class ClassroomController extends AbstractController
{
    public function __construct(
        private ClassroomRepository $classroomRepository,
        private ClassroomService $classroomService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/classroom/index.html.twig', [
            'classrooms' => $this->classroomRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?Classroom $classroom = null): Response
    {
        if (!$classroom) {
            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('admin/classroom/show.html.twig', [
            'classroom' => $this->classroomRepository->find($classroom->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function createAndEdit(Request $request, ?Classroom $classroom = null): Response
    {
        $result = $this->classroomService->createAndEditClassroom($request, $classroom);

        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('classroom_index');
        }

        return $this->render('admin/classroom/create_edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, Classroom $classroom, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = (string) $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$classroom->getId(), $token))) {
            $this->classroomRepository->remove($classroom);

            $this->addFlash('success', 'Classe supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('classroom_index');
    }
}
