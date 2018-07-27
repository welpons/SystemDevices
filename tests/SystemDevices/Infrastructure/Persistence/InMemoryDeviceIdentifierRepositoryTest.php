<?php

namespace App\Tests\SystemDevices\Infrastructure\Persistence;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use PHPUnit\Framework\TestCase;

/**
 * Description of InMemoryDeviceIdentifierRepositoryTest
 *
 * @author felix
 */
class InMemoryDeviceIdentifierRepositoryTest extends TestCase 
{
    private $repository;
    
    public function setUp() 
    {
        parent::setUp();
        $this->repository = new InMemoryDeviceIdentifierRepository();
    }
    
     
    /**
     * @group infrastructure_persistence_dev_identifier_repository
     */
    public function testFindUnregisteredDevice() 
    {
        $deviceId = DeviceId::create('foo');
        $id = DeviceIdentifierId::create();
        $identifier = Identifier::fromString('SN1234', 'serial_number');
        $deviceIdentifierToRegister = $this->createMock(DeviceIdentifier::class);
        $deviceIdentifierToRegister->method('id')
             ->willReturn($id);          
        $deviceIdentifierToRegister->method('deviceId')
             ->willReturn($deviceId);
        $deviceIdentifierToRegister->method('identifier')
             ->willReturn($identifier);  
        $this->assertNull($this->repository->deviceOfId($id));        
    }    
    
    /**
     * @group infrastructure_persistence_dev_identifier_repository
     */
    public function testAddDeviceIdentifier()
    {
        $deviceId = DeviceId::create('foo');
        $id = DeviceIdentifierId::create();
        $identifier = Identifier::fromString('SN1234', 'serial_number');
        $deviceIdentifierToRegister = $this->createMock(DeviceIdentifier::class);
        $deviceIdentifierToRegister->method('id')
             ->willReturn($id);          
        $deviceIdentifierToRegister->method('deviceId')
             ->willReturn($deviceId);
        $deviceIdentifierToRegister->method('identifier')
             ->willReturn($identifier);        
        $this->repository->add($deviceIdentifierToRegister);

        $deviceIdentifier = $this->repository->deviceOfId($id);
        $this->assertTrue($deviceIdentifier instanceof DeviceIdentifier);
        $this->assertEquals('SN1234', $deviceIdentifier->identifier()->value());
    }     
    
    /**
     * @group infrastructure_persistence_dev_identifier_repository
     */
    public function testAddMultipleDeviceIdentifier()
    {
        $deviceId = DeviceId::create('foo');
        $SN = Identifier::fromString('SN1234', 'serial_number');
        $MAC = Identifier::fromString('FA:88:A0', 'mac_address');
        $deviceIdentifierToRegisterSN = $this->createMock(DeviceIdentifier::class);
        $deviceIdentifierToRegisterSN->method('id')
             ->willReturn(DeviceIdentifierId::create());        
        $deviceIdentifierToRegisterSN->method('deviceId')
             ->willReturn($deviceId);
        $deviceIdentifierToRegisterSN->method('identifier')
             ->willReturn($SN);         

        $deviceIdentifierToRegisterMAC = $this->createMock(DeviceIdentifier::class);
        $deviceIdentifierToRegisterMAC->method('id')
             ->willReturn(DeviceIdentifierId::create());
        $deviceIdentifierToRegisterMAC->method('deviceId')
             ->willReturn($deviceId);        
        $deviceIdentifierToRegisterMAC->method('identifier')
             ->willReturn($MAC);  
        
        $this->repository->add($deviceIdentifierToRegisterSN);
        $this->repository->add($deviceIdentifierToRegisterMAC);
        
        $repository = new \ReflectionObject($this->repository);
        $devices = $repository->getProperty('deviceIdentifiers');
        $devices->setAccessible(true); 
        $devicesArray = $devices->getValue($this->repository);
        
        $this->assertTrue(is_array($devicesArray) && 2 == count($devicesArray));        
    }     
    
    /**
     * @group infrastructure_persistence_dev_identifier_repository
     */
    public function testRemoveDeviceIdentifier()
    {
        $id = DeviceIdentifierId::create();
        $deviceId = DeviceId::create('foo');
        $SN = Identifier::fromString('SN1234', 'serial_number');
        $deviceIdentifierToRegisterSN = $this->createMock(DeviceIdentifier::class);
        $deviceIdentifierToRegisterSN->method('id')
             ->willReturn($id);        
        $deviceIdentifierToRegisterSN->method('deviceId')
             ->willReturn($deviceId);
        $deviceIdentifierToRegisterSN->method('identifier')
             ->willReturn($SN); 
        $repositoryInMemory = new InMemoryDeviceIdentifierRepository();
        $repositoryInMemory->add($deviceIdentifierToRegisterSN);
        $repositoryInMemory->remove($id);
        
        $repository = new \ReflectionObject($this->repository);
        $devices = $repository->getProperty('deviceIdentifiers');
        $devices->setAccessible(true); 
        $devicesArray = $devices->getValue($this->repository);
        $this->assertTrue(is_array($devicesArray) && 0 == count($devicesArray));        
    }        
    
    

            
}
