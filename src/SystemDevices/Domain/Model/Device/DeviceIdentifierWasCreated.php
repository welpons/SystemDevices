<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Shared\DomainEvent;

/**
 * Description of DeviceIdentifierWasCreated
 *
 * @author felix
 */
class DeviceIdentifierWasCreated implements DomainEvent
{
    /**
     * @var string
     */
    private $deviceId; 
    
    /**
     * @var string 
     */
    private $type;
    
    /**
     * @var string 
     */    
    private $value;
    
    /**
     * @var bool 
     */    
    private $isReference;
    
    /**
     * @var \DateTimeImmutable 
     */    
    private $ocurredOn;
    
    public function __construct(string $deviceId, string $type, string $value, bool $isReferenceIdentifier = false) 
    {
        $this->deviceId = $deviceId;
        $this->type = $type;
        $this->value = $value;
        $this->isReference = $isReferenceIdentifier;
        $this->ocurredOn = new \DateTimeImmutable();
    }
        
    public function ocurredOn(): \DateTimeImmutable 
    {
        return $this->ocurredOn;
    }
    
    public function getTypeName() : string
    {
        return 'DeviceIdentifierWasCreated';
    }        

    public function getOcurredOn() : string
    {
        return $this->ocurredOn->getTimestamp();
    }        
    
    public function getDeviceId() : string
    {
        return $this->deviceId;
    }        
    
    public function getType() : string
    {
        return $this->type;
    }     
    
    public function getValue() : string
    {
        return $this->value;
    }        
 
    public function isReferenceIdentifier() : bool
    {
        return $this->isReference;
    }        
}
