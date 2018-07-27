<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Shared\DomainEvent;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;

/**
 * Description of DeviceIdentifierWasCreated
 *
 * @author felix
 */
class DeviceIdentifierWasCreated implements DomainEvent
{
    private $deviceIdentifier;
    
    public function __construct(DeviceIdentifier $deviceIdentifier) 
    {
        $this->deviceIdentifier = $deviceIdentifier;
    }
    
    
    public function ocurredOn(): \DateTimeImmutable 
    {
        return new \DateTimeImmutable();
    }

    public function deviceIdentifier()
    {
        return $this->deviceIdentifier;
    }     
    
       
}
