<?php

namespace App\Tests\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\RegisteredDevice;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\Model\ModelId;
use App\SystemDevices\Domain\Model\Device\Subscription\Subscription;
use PHPUnit\Framework\TestCase;


/**
 * Description of ConnectedDeviceTest
 *
 * @author felix
 */
class RegisteredDeviceTest extends TestCase
{
    /**
     * @group domain_model_rgiestered_device
     */
    public function testInstantiate()
    {
        $connectedDevice = new RegisteredDevice(DeviceId::create(), ModelId::create(), new \DateTimeImmutable(), Subscription::create(new \DateTimeImmutable(), new \DateTimeImmutable('tomorrow')));
        $this->assertTrue($connectedDevice instanceof RegisteredDevice);
    }        
}
