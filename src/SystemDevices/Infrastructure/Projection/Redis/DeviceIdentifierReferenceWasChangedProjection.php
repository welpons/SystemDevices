<?php

namespace App\SystemDevices\Infrastructure\Projection\Redis;

use App\SystemDevices\Infrastructure\Projection\ProjectionInterface;
use Predis\ClientInterface;

/**
 * Description of DeviceRferenceIdentifierWasChangedProjection
 *
 * @author felix
 */
class DeviceIdentifierReferenceWasChangedProjection extends DeviceIdentifierProjection implements ProjectionInterface
{

    public function listenTo(): string 
    {
        // return DeviceReferenceIdentifierWasChanged::class;
    }

    public function project(\stdClass $event) 
    {
        $this->client->hmset($event->device_id, $this->normalizeWithIndexDeviceId($event));
        $this->client->hmset($event->value, $this->normalizeWithIndexValue($event));      
    } 


}
