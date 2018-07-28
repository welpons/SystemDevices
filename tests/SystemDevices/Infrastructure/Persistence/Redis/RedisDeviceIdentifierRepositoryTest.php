<?php

namespace App\Tests\SystemDevices\Infrastructure\Persistence\Redis;

use PHPUnit\Framework\TestCase;
use Predis\Client;
use App\SystemDevices\Infrastructure\Persistence\Redis\RedisDeviceIdentifierRepository;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;

/**
 * Description of RedisDeviceIdentifierRepositoryTest
 *
 * @author felix
 */
class RedisDeviceIdentifierRepositoryTest extends TestCase 
{
    private $client;
    
    public function setUp()
    {
        parent::setUp();
        $this->client  = new Client();
    }     
    
    public function tearDown() 
    {
        parent::tearDown();
        
    }
    
    public function testInstantiation()
    {
        $repository = new RedisDeviceIdentifierRepository($this->client);
        $this->assertTrue($repository instanceof DeviceIdentifierRepositoryInterface);
    }       
    
    /**
     * @group predis_repository
     */
    public function testAddDeviceIdentifier()
    {

        $hash = uniqid();        
        $this->client->del($hash);
        $this->client->del('SN1234');
        $repository = new RedisDeviceIdentifierRepository($this->client);
        $deviceIdentifier = DeviceIdentifier::addNew($hash, 'serial_number', 'SN1234');
        $repository->add($deviceIdentifier);
        $indexValue = $this->client->hgetall('SN1234');
        $this->assertTrue(is_array($indexValue));        
        $this->assertEquals($hash, $indexValue['device_id']);
        $indexDeviceId = $this->client->hgetall($hash);
        $this->assertTrue(is_array($indexDeviceId));
        $this->assertEquals('SN1234', $indexDeviceId['serial_number']);        
        
    }    

    /**
     * @group predis_repository
     */
    public function testNextIdentity()
    {
        $repository = new RedisDeviceIdentifierRepository($this->client);
        $identity = $repository->nextIdentity();
        $this->assertTrue(is_string($identity) && 0 < strlen($identity));
    }     
    
    
}
