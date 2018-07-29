<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierWasCreated;


/**
 * Description of DeviceIdentifierWasCreatedProjection
 *
 * @author felix
 */
class DeviceIdentifierWasCreatedProjection extends DeviceIdentifierProjection implements ProjectionInterface
{

    public function listenTo(): string 
    {
        return DeviceIdentifierWasCreated::class;
    }

    public function project(\stdClass $event) 
    {
         $this->client->hmset($event->device_id, $this->normalizeWithIndexDeviceId($event));
         $this->client->hmset($event->value, $this->normalizeWithIndexValue($event));         
    }
}
