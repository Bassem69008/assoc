<?php

namespace App\Controller\Admin;

use App\Entity\Users\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DashboardController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        if ($user instanceof User) {
            if (false === $user->getIsVerified()) {
                return $this->redirectToRoute('app_logout');
            }
        }

        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
        ]);
    }
}
