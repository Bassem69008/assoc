<?php

namespace App\Controller\Admin;

use App\Entity\ParentEntity;
use App\Repository\ParentEntityRepository;
use App\Service\ParentService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/parent', name: 'parent_')]
class ParentController extends AbstractController
{
    public function __construct(
        private ParentEntityRepository $ParentEntityRepository,
        private ParentService $parentService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/parent/index.html.twig', [
            'parents' => $this->ParentEntityRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?ParentEntity $parent = null): Response
    {
        if (!$parent) {
            return $this->redirectToRoute('parent_index');
        }

        return $this->render('admin/parent/show.html.twig', [
            'parent' => $this->ParentEntityRepository->find($parent->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $result = $this->parentService->create($request);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('parent_index');
        }

        return $this->render('admin/parent/create.html.twig', $result);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, ?ParentEntity $parent = null): Response
    {
        if (!$parent) {
            // chnger vers la page d'erreur not found
            return $this->redirectToRoute('parent_index');
        }
        $result = $this->parentService->edit($request, $parent);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('parent_index');
        }

        return $this->render('admin/parent/edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, ParentEntity $parent, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$parent->getId(), $token))) {
            $this->ParentEntityRepository->remove($parent);

            $this->addFlash('success', 'Parent supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('parent_index');
    }
}
