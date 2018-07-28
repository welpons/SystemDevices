<?php

namespace App\Tests\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Shared\DomainEvent;
use PHPUnit\Framework\TestCase;

/**
 * Description of DeviceIdentifierTest
 *
 * @author felix
 */
class DeviceIdentifierTest extends TestCase 
{
    /**
     * @group domain_model_device_identifier
     */    
    public function testCreateObjectWithFactoryMethod()
    {
        $deviceIdentifier = DeviceIdentifier::addNew(uniqid(), 'mac_address', '1B:8A:EE');
        $this->assertTrue($deviceIdentifier instanceof DeviceIdentifier);
    }     
    
    /**
     * @group domain_model_device_identifier
     */    
    public function testGetMethods()
    {
        $deviceId = uniqid();
        $deviceIdentifier = DeviceIdentifier::addNew($deviceId, 'mac_address', '1B:8A:EE');
        $this->assertEquals('1B:8A:EE', $deviceIdentifier->identifier()->value());
        $this->assertEquals('mac_address', $deviceIdentifier->identifier()->type());
        $this->assertEquals($deviceId, $deviceIdentifier->deviceId()->id());
        $this->assertTrue(is_string($deviceIdentifier->id()->id()) && 0 < strlen($deviceIdentifier->id()->id()));
    }  

    /**
     * @group domain_model_device_identifier
     */    
    public function testRecordedEvents()
    {
        $deviceId = uniqid();
        $deviceIdentifier = DeviceIdentifier::addNew($deviceId, 'mac_address', '1B:8A:EE');
        $domainEvents = $deviceIdentifier->recordedEvents();
        $this->assertTrue(is_array($domainEvents) && 1 == count($domainEvents));
        foreach($domainEvents as $domainEvent) {
            $this->assertTrue($domainEvent instanceof DomainEvent);
        }
    }        
}
