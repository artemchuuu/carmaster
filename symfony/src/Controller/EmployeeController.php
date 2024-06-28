<?php

namespace App\Controller;

use CarMaster\Manager\EmployeeManager;
use CarMaster\Entity\Company;
use CarMaster\Entity\Employee;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class EmployeeController extends AbstractController
{
    #[Route('/employee/{id}', name: 'app_employee')]
    public function index(string $id, EntityManagerInterface $entityManager): Response
    {
        $employee = $entityManager->getRepository(Employee::class)->find($id);

        return new JsonResponse($employee->getFullInfo());
    }

    #[Route('/employee/{firstName}/{email}', name: 'app_employee_create')]
    public function create(
        string $firstName,
        string $email,
        EntityManagerInterface $entityManager,
        EmployeeManager $employeeManager
    ): Response {
        $company = $entityManager->getRepository(Company::class)->findOneBy([
            'name' => $firstName,
            'email' => $email
        ]);

        if (!$company) {
            throw $this->createNotFoundException('Company not found');
        }

        return new JsonResponse($employeeManager->createEmployee($company)->getFullInfo());
    }

    #[Route('/employees/high-salary/{count}', name: 'app_employee_high_salary')]
    public function EmployeesWithHighestSalary(string $count, EntityManagerInterface $entityManager): Response
    {
        $employeeRepository = $entityManager->getRepository(Employee::class);

        return new JsonResponse($employeeRepository->findEmployeesWithHighestSalary($count));
    }
}
