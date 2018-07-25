<?php

namespace App\Test\SystemDevices\Infrastructure\DeviceIdentifiersFinders\LNI;

use PHPUnit\Framework\TestCase;
use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\LNI\LNIDeviceIdentifiersFinder;

/**
 * Description of LNIDeviceIdentifiersFinderTest
 *
 * @author felix
 */
class LNIDeviceIdentifiersFinderTest extends TestCase
{
    /**
     * @group lni_device_identifiers_finder
     */
    public function testDataToProcess()
    {
        $payload = file_get_contents(dirname(__FILE__) ."/Hem7081it.json");        
        $lniData = json_decode($payload, true);    
        
        $lniFinder = new LNIDeviceIdentifiersFinder();        
        $identifiers = $lniFinder->findIdentifiers($lniData);        
        $dataToProcess = $lniFinder->dataToProcress();
        
        $this->assertTrue(is_array($dataToProcess));
    }       
    
    /**
     * @group lni_device_identifiers_finder
     */
    public function testFindIdentifiersFindIdentifiers()
    {
        $payload = file_get_contents(dirname(__FILE__) ."/Hem7081it.json");        
        $lniData = json_decode($payload, true);            

        $lniFinder = new LNIDeviceIdentifiersFinder();
        $identifiers = $lniFinder->findIdentifiers($lniData);
        
       
        $this->assertTrue(3 == $identifiers->count());
        $serialNumberIdentifier = $identifiers->current();
        $this->assertEquals('002209225838925b', $serialNumberIdentifier->toString());
        $identifiers->next();
        $macAddressIdentifier = $identifiers->current();
        $this->assertEquals('00:22:58:38:92:5B', $macAddressIdentifier->toString());
    }   
    
      
}
