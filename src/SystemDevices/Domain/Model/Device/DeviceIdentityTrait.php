<?php



namespace App\SystemDevices\Domain\Model\Device;

/**
 * Description of Device
 *
 * @author felix
 */
trait DeviceIdentityTrait 
{
    /**
     * @var App\SystemDevices\Domain\Model\Device\DeviceId 
     */
    private $deviceId;
    
    public function deviceId(): DeviceId
    {
        return $this->deviceId;
    }

    public function __toString()
    {
        return $this->deviceId->id();
    }    
}
