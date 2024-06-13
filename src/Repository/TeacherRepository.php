<?php

namespace App\Repository;

use App\Entity\Teacher;
use App\Repository\Trait\RemoveTrait;
use App\Repository\Trait\SaveTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teacher>
 */
class TeacherRepository extends ServiceEntityRepository
{
    use SaveTrait;
    use RemoveTrait;

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }
}
