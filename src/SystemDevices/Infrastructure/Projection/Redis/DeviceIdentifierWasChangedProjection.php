<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use App\SystemDevices\Infrastructure\Projection\ProjectorInterface;
use Predis\ClientInterface;

/**
 * Description of DeviceIdentifierWasChangedProjection
 *
 * @author felix
 */
class DeviceIdentifierWasChangedProjection implements ProjectionInterface, ProjectorInterface
{
    private $client;
    
    public function __construct(ClientInterface $client) 
    {
        $this->client = $client;
    }

    public function listenTo(): string 
    {
        // return DeviceIdentifierWasChanged::class;
    }

    public function project(array $events) 
    {
        // $this->client->hmset($deviceIdentifier->deviceId()->id(), $this->normalizeWithIndexDeviceId($deviceIdentifier));
        // $this->client->hmset($deviceIdentifier->identifier()->value(), $this->normalizeWithIndexValue($deviceIdentifier)); 
        
    } 

}
