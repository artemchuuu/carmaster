<?php

declare(strict_types=1);

namespace CarMaster\Entity;

use App\Repository\ServiceOrderRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: ServiceOrderRepository::class)]
#[Table(name: 'service_order')]
class ServiceOrder implements ServiceOrderInterface
{
    #[Id]
    #[GeneratedValue]
    #[Column(name: 'id', type: 'integer')]
    private int $id;

    #[Column(type: 'integer')]
    private int $serviceNumber;

    #[ManyToOne(targetEntity: Car::class, inversedBy: 'orders')]
    #[JoinColumn(name: 'car_id', referencedColumnName: 'id')]
    private Car $car;

    #[ManyToOne(targetEntity: Part::class, inversedBy: 'orders')]
    #[JoinColumn(name: 'part_id', referencedColumnName: 'id')]
    private Part $part;

    #[Column(name: 'work_hours', type: 'integer')]
    private int $workHours;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getServiceNumber(): int
    {
        return $this->serviceNumber;
    }

    /**
     * @param int $serviceNumber
     * @return void
     */
    public function setServiceNumber(int $serviceNumber): void
    {
        $this->serviceNumber = $serviceNumber;
    }

    /**
     * @return Car
     */
    public function getCar(): Car
    {
        return $this->car;
    }

    /**
     * @param Car $car
     * @return void
     */
    public function setCar(Car $car): void
    {
        $this->car = $car;
    }

    /**
     * @return Part
     */
    public function getPart(): Part
    {
        return $this->part;
    }

    /**
     * @param Part $part
     * @return void
     */
    public function setPart(Part $part): void
    {
        $this->part = $part;
    }

    /**
     * @return int
     */
    public function getWorkHours(): int
    {
        return $this->workHours;
    }

    /**
     * @param int $workHours
     * @return void
     */
    public function setWorkHours(int $workHours): void
    {
        $this->workHours = $workHours;
    }

    /**
     * @return array
     */
    public function getFullInfo(): array
    {
        return [
            'id' => $this->getId(),
            'serviceNumber' => $this->getServiceNumber(),
            'car' => $this->getCar()->getVinCode(),
            'part' => $this->getPart()->getName(),
            'workHours' => $this->getWorkHours(),
        ];
    }
}