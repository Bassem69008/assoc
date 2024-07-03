<?php

namespace App\Controller\Admin;

use App\Entity\Subject;
use App\Form\SubjectType;
use App\Repository\SubjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/subject', name: 'subject_')]
class SubjectController extends AbstractController
{
    public function __construct(private SubjectRepository $subjectRepository)
    {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/subject/index.html.twig', [
            'subjects' => $this->subjectRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?Subject $subject = null): Response
    {
        if (!$subject) {
            return $this->redirectToRoute('subject_index');
        }

        return $this->render('admin/subject/show.html.twig', [
            'subject' => $this->subjectRepository->find($subject->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    #[Route('/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    public function createAndEdit(Request $request, ?Subject $subject = null): Response
    {
        if (!$subject) {
            $subject = new Subject();
        }
        $form = $this->createForm(SubjectType::class, $subject);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->subjectRepository->save($subject);

            return $this->redirectToRoute('subject_index');
        }

        return $this->render('admin/subject/create_edit.html.twig',
            [
                'form' => $form->createView(),
                'editMode' => null !== $subject->getId(),
            ]);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, Subject $subject, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$subject->getId(), $token))) {
            $this->subjectRepository->remove($subject);

            $this->addFlash('success', 'Matière supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('subject_index');
    }
}
