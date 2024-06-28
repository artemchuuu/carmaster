<?php

namespace CarMaster\Entity;

interface ServiceOrderInterface
{
    public function getServiceNumber(): int;

    public function getCar(): Car;

    public function getPart(): Part;

    public function getWorkHours(): int;

    public function getFullInfo(): array;
}