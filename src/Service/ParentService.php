<?php

namespace App\Service;

use App\Entity\ParentEntity;
use App\Form\ParentType;
use App\Repository\ParentEntityRepository;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class ParentService
{
    public function __construct(
        private FormFactoryInterface $formFactory,
        private ParentEntityRepository $parentRepository,
    ) {
    }

    /**
     * @return array<string, bool|FormView>
     */
    public function create(Request $request): array
    {
        $parent = new ParentEntity();
        $form = $this->formFactory->create(ParentType::class, $parent);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Créer et associer les  parents
            $this->parentRepository->save($parent);

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
    public function edit(Request $request, ParentEntity $parent): array
    {
        $form = $this->formFactory->create(ParentType::class, $parent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Créer et associer les étudiants
            $this->parentRepository->save($parent);

            return ['isSuccess' => true];
        }

        return [
            'isSuccess' => false,
            'form' => $form->createView(),
        ];
    }
}
