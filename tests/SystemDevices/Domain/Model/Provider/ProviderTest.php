<?php

namespace App\Tests\SystemDevices\Domain\Model\Provider;

use PHPUnit\Framework\TestCase;
use App\SystemDevices\Domain\Model\Provider\Provider;

/**
 * Description of ProviderTest
 *
 * @author felix
 */
class ProviderTest extends TestCase
{
    /**
     * @group domain_model_provider
     */
    public function testProviderfromString()
    {
        $provider = Provider::fromString('QCL', 'json');
        
        $this->assertTrue($provider instanceof Provider);
    }     
    
    /**
     * @group domain_model_provider
     * @expectedException App\SystemDevices\Domain\Model\Provider\InvalidProviderPayloadFormatException
     */
    public function testProviderWrongFormat()
    {
        $provider = Provider::fromString('QCL', 'unknown_format', ['json']);
    }       
    
    /**
     * @group domain_model_provider
     * @expectedException App\SystemDevices\Domain\Model\Provider\InvalidProviderNameException
     */
    public function testProviderEmptyName()
    {
        $provider = Provider::fromString('', 'json');
    }      
}
