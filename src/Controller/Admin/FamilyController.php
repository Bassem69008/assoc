<?php

namespace App\Controller\Admin;

use App\Entity\Family;
use App\Repository\FamilyRepository;
use App\Service\FamilyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/family', name: 'family_')]
class FamilyController extends AbstractController
{
    public function __construct(
        private FamilyRepository $familyRepository,
        private FamilyService $familyService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/family/index.html.twig', [
            'families' => $this->familyRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?Family $family = null): Response
    {
        if (!$family) {
            return $this->redirectToRoute('family_index');
        }

        return $this->render('admin/family/show.html.twig', [
            'family' => $this->familyRepository->find($family->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $result = $this->familyService->create($request);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('family_index');
        }

        return $this->render('admin/family/create.html.twig', $result);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, ?Family $family = null): Response
    {
        if (!$family) {
            // chnger vers la page d'erreur not found
            return $this->redirectToRoute('family_index');
        }
        $result = $this->familyService->edit($request, $family);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('family_index');
        }

        return $this->render('admin/family/edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, Family $family, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$family->getId(), $token))) {
            $this->familyRepository->remove($family);

            $this->addFlash('success', 'Famille supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('family_index');
    }
}
