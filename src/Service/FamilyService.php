<?php

namespace App\Service;

use App\Entity\Family;
use App\Entity\ParentEntity;
use App\Form\CreateFamilyType;
use App\Repository\FamilyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class FamilyService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private FamilyRepository $familyRepository,
        private EntityManagerInterface $entityManager
    ) {
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function create(Request $request): array
    {
        $family = new Family();
        $this->attachParents($family);
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

    private function attachParents(Family $family): void
    {
        $parent1 = new ParentEntity();
        $parent2 = new ParentEntity();
        $family->addParentEntity($parent1);
        $family->addParentEntity($parent2);

        // Persist the Family entity
        $this->entityManager->persist($family);
    }
}
