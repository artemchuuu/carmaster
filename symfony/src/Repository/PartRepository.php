<?php

namespace App\Repository;

use CarMaster\Entity\Part;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class PartRepository extends ServiceEntityRepository
{
    const PARTS_PER_PAGE = 10;

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Part::class);
    }

    public function findPage(int $page = 1)
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id')
            ->getQuery()
            ->setFirstResult(self::PARTS_PER_PAGE * $page - self::PARTS_PER_PAGE)
            ->setMaxResults(self::PARTS_PER_PAGE)
            ->getResult();
    }
}