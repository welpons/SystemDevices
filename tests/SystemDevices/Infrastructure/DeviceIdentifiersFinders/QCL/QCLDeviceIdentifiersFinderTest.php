<?php

namespace App\Test\SystemDevices\Infrastructure\DeviceIdentifiersFinders\QCL;

use PHPUnit\Framework\TestCase;
use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\QCL\QCLDeviceIdentifiersFinder;

/**
 * Description of QCLDeviceIdentifiersFinderTest
 *
 * @author felix
 */
class QCLDeviceIdentifiersFinderTest extends TestCase
{
    /**
     * @group qcl_device_identifiers_finder
     */
    public function testDataToProcess()
    {
        $payload = file_get_contents(dirname(__FILE__) ."/rawHbf206it.json");        
        $decodedData = json_decode($payload, true);   
        $qclData = $decodedData['post'];   
        
        $qclFinder = new QCLDeviceIdentifiersFinder();        
        $identifiers = $qclFinder->findIdentifiers($qclData);        
        $dataToProcess = $qclFinder->dataToProcress();
        
        $this->assertTrue(is_array($dataToProcess));
    }       
    
    /**
     * @group qcl_device_identifiers_finder
     */
    public function testFindIdentifiersFindIdentifiers()
    {
        $payload = file_get_contents(dirname(__FILE__) ."/rawHbf206it.json");        
        $decodedData = json_decode($payload, true);   
        $qclData = $decodedData['post'];         

        $qclFinder = new QCLDeviceIdentifiersFinder();
        $identifiers = $qclFinder->findIdentifiers($qclData);
        
       
        $this->assertTrue(3 == $identifiers->count());
        $serialNumberIdentifier = $identifiers->current();
        $this->assertEquals('201004-00356F', $serialNumberIdentifier->toString());
        $identifiers->next();
        $macAddressIdentifier = $identifiers->current();
        $this->assertEquals('00:22:58:07:78:71', $macAddressIdentifier->toString());
    }   
    
    /**
     * @group qcl_device_identifiers_finder_
     * @expectedException App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\QCL\QclDataNotFoundException
     */
    public function testUndefinedQclJsonParameterInPayload()
    {
        $payload = file_get_contents(dirname(__FILE__) ."/rawHbf206it_undefined_qcl_json_parameter.json");
        $decodedData = json_decode($payload, true);   
        $qclData = $decodedData['post'];          
        $qclFinder = new QCLDeviceIdentifiersFinder();     
        $identifiers = $qclFinder->findIdentifiers($qclData);
    }        
}
