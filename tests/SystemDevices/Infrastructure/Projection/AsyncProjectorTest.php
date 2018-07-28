<?php

namespace App\Tests\SystemDevices\Infrastructure\Projection;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\SystemDevices\Infrastructure\Projection\AsyncProjector;
use App\SystemDevices\Infrastructure\Projection\ProjectorInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierWasCreated;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

/**
 * Description of AsyncProjectorTest
 *
 * @author felix
 */
class AsyncProjectorTest extends KernelTestCase
{
    private $serializer;
    
    public function setUp() {
        parent::setUp();
        self::bootKernel();

$encoders = array(new XmlEncoder(), new JsonEncoder());
$normalizers = array(new ObjectNormalizer());

$this->serializer = new Serializer($normalizers, $encoders);   
    }
    
    /**
     * @group infrastructure_projection_async_projector
     */    
    public function testInstantiateProjector()
    {        
        $projector = new AsyncProjector(new MessageBrokerSimulator(), $this->serializer);
        $this->assertTrue($projector instanceof ProjectorInterface);
    }        
    
    /**
     * @group infrastructure_projection_async_projector
     */   
    public function testProject()
    {
        $events = [];
        $event = new DeviceIdentifierWasCreated(uniqid(), 'serial_number', 'SN1234');
        $this->assertEquals('serial_number', $event->getType());
        $events[] = $event;
        $projector = new AsyncProjector(new MessageBrokerSimulator(), $this->serializer);
        $projector->project($events);
    }        
}
