<?php

namespace App\Controller\Admin;

use App\Entity\Users\User;
use App\Repository\Users\UserRepository;
use App\Service\UsersService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/admin/users', name: 'users_')]
class UsersController extends AbstractController
{
    public function __construct(
        private UserRepository $userRepository,
        private UsersService $usersService
    ) {
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/users/index.html.twig', [
            'users' => $this->userRepository->findAll(),
        ]);
    }

    #[Route('/{id}/show', name: 'show', methods: ['GET'])]
    public function show(?User $user = null): Response
    {
        if (!$user) {
            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/show.html.twig', [
            'user' => $this->userRepository->find($user->getId()),
        ]);
    }

    #[Route('/creation', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $result = $this->usersService->createUser($request);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/create.html.twig', $result);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(Request $request, ?User $user = null): Response
    {
        if (!$user) {
            // chnger vers la page d'erreur not found
            return $this->redirectToRoute('users_index');
        }
        $result = $this->usersService->editUser($request, $user);
        if (true === $result['isSuccess']) {
            return $this->redirectToRoute('users_index');
        }

        return $this->render('admin/users/edit.html.twig', $result);
    }

    #[Route('/{id}/remove', name: 'delete', methods: ['GET', 'POST', 'DELETE'])]
    public function delete(Request $request, User $user, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $token = (string) $request->request->get('_token');

        if ($csrfTokenManager->isTokenValid(new CsrfToken('delete'.$user->getId(), $token))) {
            $this->userRepository->remove($user);

            $this->addFlash('success', 'Utilisateur supprimé avec succès');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide');
        }

        return $this->redirectToRoute('users_index');
    }
}
