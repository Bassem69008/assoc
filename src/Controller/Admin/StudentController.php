<?php

namespace App\Controller\Admin;

use App\Entity\Student;
use App\Repository\StudentRepository;
use App\Service\StudentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/student', name: 'student_')]
class StudentController extends AbstractController
{
    public function __construct(
        private StudentRepository $studentRepository,
        private StudentService $studentService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/student/index.html.twig', [
            'students' => $this->studentRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?Student $student = null): Response
    {
        if (!$student) {
            return $this->redirectToRoute('student_index');
        }

        return $this->render('admin/student/show.html.twig', [
            'student' => $this->studentRepository->find($student->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $result = $this->studentService->create($request);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('student_index');
        }

        return $this->render('admin/student/create.html.twig', $result);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, ?Student $student = null): Response
    {
        if (!$student) {
            // chnger vers la page d'erreur not found
            return $this->redirectToRoute('student_index');
        }
        $result = $this->studentService->edit($request, $student);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('student_index');
        }

        return $this->render('admin/student/edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, Student $student, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$student->getId(), $token))) {
            $this->studentRepository->remove($student);

            $this->addFlash('success', 'Étudiant supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('student_index');
    }
}
