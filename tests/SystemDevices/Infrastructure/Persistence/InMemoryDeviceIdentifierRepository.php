<?php

namespace App\Tests\SystemDevices\Infrastructure\Persistence;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;

/**
 * Description of InMemoryDeviceIdentifierRepository
 *
 * @author felix
 */
class InMemoryDeviceIdentifierRepository implements DeviceIdentifierRepositoryInterface
{
    private $deviceIdentifiers = [];
    
    public function nextIdentity() : string
    {
        return new DeviceIdentifierId();
    }    
    
    public function deviceOfId(DeviceIdentifierId $id) : ?DeviceIdentifier
    {
        if (isset($this->deviceIdentifiers[$id->id()])) {
            return $this->deviceIdentifiers[$id->id()];
        }
        
        return null;
    }    
    
    public function deviceOfDeviceId(DeviceId $deviceId) :array
    {        
        if (empty($this->deviceIdentifiers)) {
            return [];
        }
        
        $deviceIdentifiers = [];
        
        foreach($this->deviceIdentifiers as $id => $storedDeviceIdentifier) {
            if ($storedDeviceIdentifier->deviceId()->id() == $deviceId->id()) {
                $deviceIdentifiers[] = $this->deviceIdentifiers[$id];
            }
        }
        
        return $deviceIdentifiers;
    }    
        
    public function deviceOfIdentifier(Identifier $identifier) : ?DeviceIdentifier
    {
        if (empty($this->deviceIdentifiers)) {
            return null;
        }
        
        $deviceIdentifiers = [];
        
        foreach($this->deviceIdentifiers as $id => $storedDeviceIdentifier) {
            if ($storedDeviceIdentifier->identifier()->type() == $identifier->type() && $storedDeviceIdentifier->identifier()->value() == $identifier->value()) {
                return $this->deviceIdentifiers[$id];
            }
        }  
        
        return null;
    }    
   
    public function add(DeviceIdentifier $deviceIdentifier)
    {
        foreach($this->deviceIdentifiers as $id => $storedDeviceIdentifier) {
            if ($storedDeviceIdentifier->deviceId()->id() == $deviceIdentifier->deviceId()->id()) {
                if ($storedDeviceIdentifier->identifier()->type() == $deviceIdentifier->identifier()->type() || $storedDeviceIdentifier->identifier()->value() == $deviceIdentifier->identifier()->value()) {
                    throw new \Exception(sprintf('Duplicated device identifier for device with id: %s', $deviceIdentifier->deviceId()->id()));
                }                             
            }
        } 
              

        $this->deviceIdentifiers[$deviceIdentifier->id()->id()] = $deviceIdentifier;           
    }
    
    public function update(DeviceIdentifier $deviceIdentifier)
    {
        
    }        
    
    public function remove(DeviceIdentifier $deviceIdentifier)
    {
        unset($this->deviceIdentifiers[$deviceIdentifier->id()->id()]);
    }        
    
    public function findBy(array $criteria)
    {
        
    }         
}
