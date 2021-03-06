<?php

namespace App\Tests\SystemDevices\Infrastructure\Persistence;

use App\SystemDevices\Domain\Model\Device\RegisteredDevice;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\Model\ModelId;
use App\SystemDevices\Domain\Model\Device\Subscription\Subscription;
use PHPUnit\Framework\TestCase;

/**
 * Description of InMemoryRegisteredDeviceRepositoryTest
 *
 * @author felix
 */
class InMemoryRegisteredDeviceRepositoryTest extends TestCase 
{
    private $repository;
    
    public function setUp() 
    {
        parent::setUp();
        $this->repository = new InMemoryRegisteredDeviceRepository();
    }
    
    /**
     * @group infrastructure_persistence_registered_dev_repository
     */
    public function testNextIdentityReturnString()
    {
        $this->assertTrue(is_string($this->repository->nextIdentity()));
    }  
    
    /**
     * @group infrastructure_persistence_registered_dev_repository1
     */
    public function testFindUnnregisteredDevice() 
    {
        $idFoo = DeviceId::create();
        $deviceToRegisterFoo = $this->createMock(RegisteredDevice::class);
        $deviceToRegisterFoo->method('deviceId')
             ->willReturn($idFoo);
        $this->assertNull($this->repository->deviceOfId($idFoo));
        
    }    
    
    /**
     * @group infrastructure_persistence_registered_dev_repository
     */
    public function testAddRegisteredDevice()
    {
        $id = DeviceId::create('foo');
        $deviceToRegister = $this->createMock(RegisteredDevice::class);
        $deviceToRegister->method('deviceId')
             ->willReturn($id);
        $this->repository->add($deviceToRegister);
        $registeredDevice = $this->repository->deviceOfId($id);
        $this->assertTrue($registeredDevice instanceof RegisteredDevice);
        $this->assertEquals('foo', $registeredDevice->deviceId());
    }     
    
    /**
     * @group infrastructure_persistence_registered_dev_repository
     */
    public function testAddMultipleRegisteredDevice()
    {
        $idFoo = DeviceId::create('foo');
        $deviceToRegisterFoo = $this->createMock(RegisteredDevice::class);
        $deviceToRegisterFoo->method('deviceId')
             ->willReturn($idFoo);
        $idBar = DeviceId::create('bar');
        $deviceToRegisterBar = $this->createMock(RegisteredDevice::class);
        $deviceToRegisterBar->method('deviceId')
             ->willReturn($idBar);        
        $this->repository->add($deviceToRegisterFoo);
        $this->repository->add($deviceToRegisterBar);
        
        $repository = new \ReflectionObject($this->repository);
        $devices = $repository->getProperty('devices');
        $devices->setAccessible(true); 
        $devicesArray = $devices->getValue($this->repository);
        $this->assertTrue(is_array($devicesArray) && 2 == count($devicesArray));        
    }     
    
    /**
     * @group infrastructure_persistence_registered_dev_repository
     */
    public function testRemoveRegisteredDevice()
    {
        $idFoo = DeviceId::create('foo');
        $registeredDevice = $this->createMock(RegisteredDevice::class);
        $registeredDevice->method('deviceId')
             ->willReturn($idFoo);
        $repositoryInMemory = new InMemoryRegisteredDeviceRepository();
        $repositoryInMemory->add($registeredDevice);
        $repositoryInMemory->remove($idFoo);
        
        $repository = new \ReflectionObject($this->repository);
        $devices = $repository->getProperty('devices');
        $devices->setAccessible(true); 
        $devicesArray = $devices->getValue($this->repository);
        $this->assertTrue(is_array($devicesArray) && 0 == count($devicesArray));        
    }        
    
    

            
}
