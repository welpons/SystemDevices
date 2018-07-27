<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use Predis\ClientInterface;

/**
 * Description of DeviceRferenceIdentifierWasChangedProjection
 *
 * @author felix
 */
class DeviceReferenceIdentifierWasChangedProjection implements ProjectionInterface
{
    private $client;
    
    public function __construct(ClientInterface $client) 
    {
        $this->client = $client;
    }

    public function listenTo(): string 
    {
        // return DeviceReferenceIdentifierWasChanged::class;
    }

    public function project($event) 
    {
        // $this->client->hmset($deviceIdentifier->deviceId()->id(), $this->normalizeWithIndexDeviceId($deviceIdentifier));
        // $this->client->hmset($deviceIdentifier->identifier()->value(), $this->normalizeWithIndexValue($deviceIdentifier)); 
        
    } 


}
