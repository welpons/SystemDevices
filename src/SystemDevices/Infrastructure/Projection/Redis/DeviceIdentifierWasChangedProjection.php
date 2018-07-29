<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use Predis\ClientInterface;

/**
 * Description of DeviceIdentifierWasChangedProjection
 *
 * @author felix
 */
class DeviceIdentifierWasChangedProjection extends DeviceIdentifierProjection implements ProjectionInterface
{
    public function listenTo(): string 
    {
        // return DeviceIdentifierWasChanged::class;
    }

    public function project(\stdClass $event) 
    {
         $this->client->hmset($event->device_id, $this->normalizeWithIndexDeviceId($event));
         $this->client->hmset($event->value, $this->normalizeWithIndexValue($event));    
    } 

}
