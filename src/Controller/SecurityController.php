<?php

namespace App\Controller;

use App\Entity\Users\User;
use App\Form\LoginCheckType;
use App\Form\ResetPasswordType;
use App\Manager\User\ResetPasswordNotificationManager;
use App\Repository\Users\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the users
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(
        '/forgot-password',
        name: 'app_forgot_password',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function forgotPassword(
        Request $request,
        ResetPasswordNotificationManager $resetPasswordNotificationManager,
        UserRepository $userRepository,
    ): Response {
        $form = $this->createFormBuilder()->add('email', EmailType::class, [
            'label' => 'global.email',
            'attr' => [
                'placeholder' => 'Email',
            ],
        ])->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();

            $user = $userRepository->findOneBy(['email' => $email]);

            $this->addFlash('notice', [
                'messageKey' => 'Votre demande a été prise en compte. Si un compte existe avec l’adresse email saisie, un email vous sera envoyé avec un lien vous permettant de créer un nouveau mot de passe.',
                'messageData' => [],
            ]);

            if (null !== $user) {
                $resetPasswordNotificationManager->resetPasswordNotification($user);
            }

            return $this->redirectToRoute('app_forgot_password');
        }

        return $this->render('security/forgot_password.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/login-check', name: 'app_login_check')]
    public function loginCheck(
        Request $request,
    ): Response {
        $form = $this->createForm(LoginCheckType::class, [
            'expires' => $request->query->get('expires'),
            'user_email' => $request->query->get('user'),
            'hash' => $request->query->get('hash'),
        ]);

        return $this->render('security/access_reset_password.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(
        '/reset-password',
        name: 'app_reset_password',
        methods: [Request::METHOD_GET, Request::METHOD_POST]
    )]
    public function resetPassword(
        #[CurrentUser]
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        TokenInterface $token,
        Security $security
    ): Response {
        $response = $this->redirectToAppropriatePage($token, $request);
        if ($response instanceof Response) {
            return $response;
        }
        $form = $this->createForm(ResetPasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                /*
                 * New user is not active. We activate him when he first resets his password.
                 */
                if (!$user->getIsVerified()) {
                    $user->setIsVerified(true);
                }

                $entityManager->flush();

                /*
                 * We log out the user after the password reset
                 * to force him to log in with his new password.
                 */
                $security->logout(false);
                $this->addFlash('success', [
                    'messageKey' => 'security.password.reset.success',
                    'messageData' => [],
                ]);
            } catch (\Exception $e) {
                // Use a global error message in order to avoid giving too much information.
                $this->addFlash('error', [
                    'messageKey' => 'security.global.error',
                    'messageData' => [],
                ]);
            }

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/reset_password.html.twig', ['form' => $form]);
    }

    /**
     * When a user accesses this page via a login link in an email, the ResetPasswordSuccessHandler
     * sets the value "login_link_to_access_reset_password" in a token.
     * This method checks for this attribute in the token.
     *
     * If the token doesn't include this attribute and the request is a GET request,
     * the method checks the user's role.
     *
     * If the user has been granted the ROLE_ACCOUNTANT role,
     * the method redirects the user to the dashboard.
     * If the user has not been granted the ROLE_ACCOUNTANT role,
     * the method redirects the user to the homepage.
     * This prevents users without the proper token & role from accessing the reset password page.
     */
    private function redirectToAppropriatePage(TokenInterface $token, Request $request): ?Response
    {
        if ($token->hasAttribute('login_link_to_access_reset_password')) {
            return null;
        }

        if (!$request->isMethod(Request::METHOD_GET)) {
            return null;
        }

        return $this->redirectToRoute('app_admin_dashboard');
    }
}
