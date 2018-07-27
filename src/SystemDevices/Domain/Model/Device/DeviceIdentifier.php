<?php

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Shared\AggregateRoot;

/**
 * Description of DeviceIdentifier
 *
 * @author felix
 */
class DeviceIdentifier extends AggregateRoot
{
    use DeviceIdentityTrait;
    use Identifiers\IdentifierTrait;
    
    private $id;

    private $isReferenceIdentifier;
    
    public static function addNew(string $deviceId, string $type, string $value, bool $isReferenceIdentifier = false)
    {
        $id = DeviceIdentifierId::create();
        $deviceId = DeviceId::create($deviceId);
        $identifier = Identifier::fromString($value, $type);
        $deviceIdentifier = new static($id, $deviceId, $identifier, $isReferenceIdentifier);
        
        $deviceIdentifier->recordApplyAndPublishThat(
            new DeviceIdentifierWasCreated($deviceIdentifier)
        );
        
        return $deviceIdentifier;
    }    
    
    public function __construct(DeviceIdentifierId $id, DeviceId $deviceId, Identifier $identifier, bool $isReferenceIdentifier = false) 
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
    
    public function isReferenceIdentifier() : bool
    {
        return $this->isReferenceIdentifier;
    }
  
}
