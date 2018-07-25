<?php

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;


/**
 * Description of DeviceIdentifier
 *
 * @author felix
 */
class DeviceIdentifier 
{
    private $id;
    private $identifier;
    private $deviceId;
    private $isReferenceIdentifier;
    
    public function __construct(DeviceIdentifierId $id, DeviceId $deviceId, Identifier $identifier, $isReferenceIdentifier = false) 
    {
        $this->id = $id;
        $this->deviceId = $deviceId;
        $this->identifier = $identifier;
        $this->isReferenceIdentifier = $isReferenceIdentifier;
    }
    
    public function id() : DeviceIdentifierId
    {
        return $this->id;
    }        
    
    public function identifier() : Identifier
    {
        return $this->identifier;
    }

    public function deviceId() : DeviceId
    {
        return $this->deviceId;
    }

    public function isReferenceIdentifier() : bool
    {
        return $this->isReferenceIdentifier;
    }

    
}
