<?php


namespace App\SystemDevices\Infrastructure\Projection\Redis;

use Predis\ClientInterface;

/**
 * Description of DeviceIdentifierProjection
 *
 * @author felix
 */
class DeviceIdentifierProjection 
{
    private $client;
    
    public function __construct(ClientInterface $client) 
    {
        $this->client = $client;
    }
    
    protected function normalizeWithIndexValue(\stdClass $event)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            'device_id' => $deviceIdentifier->deviceId()->id(),
            'type' => $deviceIdentifier->identifier()->type(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];        
    }  
    
    protected function normalizeWithIndexDeviceId(\stdClass $event)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            $deviceIdentifier->identifier()->type() => $deviceIdentifier->identifier()->value(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];    
       
    }     //put your code here
}
