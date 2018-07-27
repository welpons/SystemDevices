<?php

namespace App\SystemDevices\Domain\Shared;

/**
 *
 * @author felix
 */
interface DomainEvent 
{
    public function ocurredOn() : \DateTimeImmutable;
}
