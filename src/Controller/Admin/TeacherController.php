<?php

namespace App\Controller\Admin;

use App\Entity\Teacher;
use App\Repository\TeacherRepository;
use App\Service\TeacherService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/teacher', name: 'teacher_')]
class TeacherController extends AbstractController
{
    public function __construct(
        private TeacherRepository $teacherRepository,
        private TeacherService $teacherService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/teacher/index.html.twig', [
            'teachers' => $this->teacherRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?Teacher $teacher = null): Response
    {
        if (!$teacher) {
            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('admin/teacher/show.html.twig', [
            'teacher' => $this->teacherRepository->find($teacher->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit')]
    public function createAndEdit(Request $request, ?Teacher $teacher = null): Response
    {
        $result = $this->teacherService->createAndEditTeacher($request, $teacher);

        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('teacher_index');
        }

        return $this->render('admin/teacher/create_edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, Teacher $teacher, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$teacher->getId(), $token))) {
            $this->teacherRepository->remove($teacher);

            $this->addFlash('success', 'Enseignant supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('teacher_index');
    }
}
