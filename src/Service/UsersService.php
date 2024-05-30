<?php

namespace App\Service;

use App\Entity\Users\User;
use App\Form\UserType;
use App\Manager\User\CreateUserNotificationManager;
use App\Repository\Users\UserRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsersService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $userRepository,
        private CreateUserNotificationManager $createUserNotificationManager
    ) {
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function createUser(Request $request): array
    {
        $user = new User();
        $user->setPassword($this->passwordHasher->hashPassword($user, User::PASSWORD_NOT_SET));
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);
            // send mail to user
            $this->createUserNotificationManager->notifyAddedUser($user);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function editUser(Request $request, User $user): array
    {
        $form = $this->formFactory->create(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userRepository->save($user);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }
}
