<?php

namespace App\Repository\Trait;

trait SaveTrait
{
    public function save(object $entity, bool $flush = true): object
    {
        $em = $this->getEntityManager();
        $em->persist($entity);
        if ($flush) {
            $em->flush();
        }

        return $entity;
    }
}
