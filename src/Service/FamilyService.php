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
        $family = new Family();
        $form = $this->formFactory->create(CreateFamilyType::class, $family);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Créer et associer les étudiants
            $this->attachStudents($family);

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
            // Créer et associer les étudiants
            $this->attachStudents($family);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }

    private function attachStudents(Family $family): void
    {
        foreach ($family->getStudents() as $student) {
            $student->setFamily($family);
        }
        // Enregistrer la famille
        $this->familyRepository->save($family);
    }
}