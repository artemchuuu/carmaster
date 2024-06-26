<?php

namespace App\Repository;

use CarMaster\Entity\Employee;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class EmployeeRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * @param int $count
     * @return array
     */
    public function findEmployeesWithHighestSalary(int $count): array
    {
        $queryBuilder = $this->createQueryBuilder('e');

        $queryBuilder
            ->orderBy('e.salary', 'DESC')
            ->where('e.age < 30');

        $employeesCount = (int)$count;
        $query = $queryBuilder->getQuery()
            ->setMaxResults($employeesCount);

        $employees = [];

        foreach ($query->getResult() as $employee) {
            /**
             * @var Employee $employees
             */
            $employees[] = $employee->getFullInfo();
        }

        return $employees;
    }
}