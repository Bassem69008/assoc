<?php

namespace App\Service;

use App\Entity\Family;
use App\Form\CreateFamilyType;
use App\Repository\FamilyRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class FamilyService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private FamilyRepository $familyRepository,
    ) {
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function create(Request $request): array
    {
        $user = new Family();
        $form = $this->formFactory->create(CreateFamilyType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->familyRepository->save($user);

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
    public function edit(Request $request, Family $family): array
    {
        $form = $this->formFactory->create(CreateFamilyType::class, $family);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->familyRepository->save($family);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }
}
