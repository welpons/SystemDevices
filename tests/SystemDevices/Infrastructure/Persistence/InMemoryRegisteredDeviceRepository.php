<?php

namespace App\Tests\SystemDevices\Infrastructure\Persistence;

use App\SystemDevices\Domain\Model\Device\RegisteredDeviceRespositoryInterface;
use App\SystemDevices\Domain\Model\Device\RegisteredDevice;
use App\SystemDevices\Domain\Model\Device\DeviceId;

/**
 * Description of DeviceRepository
 *
 * @author felix
 */
class InMemoryRegisteredDeviceRepository implements RegisteredDeviceRespositoryInterface
{
    private $devices = [];
    
    public function nextIdentity() : string
    {
        return DeviceId::create();
    }    
    
    public function deviceOfId(DeviceId $deviceId) : ?RegisteredDevice
    {
        if (isset($this->devices[$deviceId->id()])) {
            return $this->devices[$deviceId->id()];
        }
        
        return null;
    }    
   
    public function add(RegisteredDevice $device)
    {
        $this->devices[$device->deviceId()->id()] = $device;
    }
    
    public function update(RegisteredDevice $device)
    {
        if (isset($this->devices[$device->deviceId()->id()])) {
            $this->devices[$device->deviceId()->id()] = $device;
        }        
    }        
    
    public function remove(DeviceId $deviceId)
    {
        unset($this->devices[$deviceId->id()]);
    }        
    
    public function findBy(array $criteria) : array
    {
        
    }        
}
