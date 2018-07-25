<?php

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;

/**
 *
 * @author felix
 */
interface DeviceIdentifierRepositoryInterface 
{
    public function nextIdentity() : string;    
    
    public function deviceOfId(DeviceIdentifierId $id) : ?DeviceIdentifier;
    
    public function deviceOfDeviceId(DeviceId $deviceId) : array;
        
    public function deviceOfIdentifier(Identifier $identifier) : ?DeviceIdentifier;
   
    public function add(DeviceIdentifier $deviceIdentifier); 
    
    public function update(DeviceIdentifier $deviceIdentifier); 
    
    public function remove(DeviceIdentifier $deviceIdentifier);
    
    public function findBy(array $criteria); 
}
