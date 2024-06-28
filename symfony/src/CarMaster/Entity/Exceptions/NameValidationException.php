<?php

declare(strict_types=1);

namespace CarMaster\Entity\Exceptions;

use RuntimeException;

class NameValidationException extends RuntimeException
{
    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct($name);
    }
}