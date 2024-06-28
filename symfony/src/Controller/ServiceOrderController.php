<?php

namespace App\Controller;

use CarMaster\Entity\Car;
use CarMaster\Entity\Part;
use CarMaster\Entity\ServiceOrder;
use CarMaster\Manager\ServiceOrderManager;
use CarMaster\Service\ServiceCostCalculator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceOrderController extends AbstractController
{
    #[Route('/service/{id}/total-cost', name: 'app_service_order_total_cost')]
    public function totalCost(
        $id,
        ServiceCostCalculator $serviceCostCalculator,
        EntityManagerInterface $entityManager
    ): JsonResponse {
        $serviceOrderRepository = $entityManager->getRepository(ServiceOrder::class);

        $serviceOrder = $serviceOrderRepository->find($id);

        $totalCost = $serviceCostCalculator->calculateTotalCost($serviceOrder);

        $result = [
            'serviceNumber' => $serviceOrder->getServiceNumber(),
            'carBrand' => $serviceOrder->getCar()->getBrand(),
            'carModel' => $serviceOrder->getCar()->getModel(),
            'carVinCode' => $serviceOrder->getCar()->getVinCode(),
            'totalCost' => $totalCost,
        ];

        return new JsonResponse($result);
    }

    #[Route('/service-order/create/{serviceNumber}/{carVinCode}/{partId}/{workHours}', name: 'app_service_order_create')]
    public function create(
        int $serviceNumber,
        string $carVinCode,
        int $partId,
        int $workHours,
        EntityManagerInterface $entityManager,
        ServiceOrderManager $serviceOrderManager
    ): JsonResponse {
        $car = $entityManager->getRepository(Car::class)->findOneBy([
            'vinCode' => $carVinCode,
        ]);

        $part = $entityManager->getRepository(Part::class)->findOneBy([
            'id' => $partId,
        ]);

        return new JsonResponse(
            $serviceOrderManager->createOrder($serviceNumber, $car, $part, $workHours)->getFullInfo()
        );
    }
}
