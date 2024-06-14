<?php

namespace App\Repository;

use App\Entity\Classroom;
use App\Repository\Trait\RemoveTrait;
use App\Repository\Trait\SaveTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Classroom>
 */
class ClassroomRepository extends ServiceEntityRepository
{
    use SaveTrait;
    use RemoveTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Classroom::class);
    }
}
