<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use App\SystemDevices\Infrastructure\Projection\ProjectorInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierWasCreated;
use Predis\ClientInterface;

/**
 * Description of DeviceIdentifierWasCreatedProjection
 *
 * @author felix
 */
class DeviceIdentifierWasCreatedProjection implements ProjectionInterface, ProjectorInterface
{
    private $client;
    
    public function __construct(ClientInterface $client) 
    {
        $this->client = $client;
    }

    public function listenTo(): string 
    {
        return DeviceIdentifierWasCreated::class;
    }

    public function project(array $events) 
    {
         $this->client->hmset($event->deviceIdentifier()->deviceId()->id(), $this->normalizeWithIndexDeviceId($event));
         $this->client->hmset($event->deviceIdentifier()->identifier()->value(), $this->normalizeWithIndexValue($event)); 
        
    }
    
    private function normalizeWithIndexValue(DeviceIdentifier $deviceIdentifier)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            'device_id' => $deviceIdentifier->deviceId()->id(),
            'type' => $deviceIdentifier->identifier()->type(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];        
    }  
    
    private function normalizeWithIndexDeviceId(DeviceIdentifier $deviceIdentifier)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            $deviceIdentifier->identifier()->type() => $deviceIdentifier->identifier()->value(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];    
       
    } 
}
