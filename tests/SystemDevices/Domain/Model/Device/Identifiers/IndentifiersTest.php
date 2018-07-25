<?php

namespace App\Tests\SystemDevices\Domain\Model\Device\Identifiers;

use PHPUnit\Framework\TestCase;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers;
use App\SystemDevices\Domain\Model\Device\Identifiers\IdentifierTypes;
/**
 * Description of IndentifiersTest
 *
 * @author felix
 */
class IndentifiersTest extends TestCase
{
    /**
     * @group domain_model_identifiers
     */
    public function testIdentifiersElements()
    {
        $identifiers = new Identifiers();
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS, IdentifierTypes::LISTING);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress);        
        foreach($identifiers as $type => $identifier) {
            $this->assertTrue($identifier instanceof Identifier);
        }
    }       
    
    /**
     * @group domain_model_identifiers
     */
    public function testAddIdentifiersWithDifferentTypes()
    {
        $identifiers = new Identifiers();
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS, IdentifierTypes::LISTING);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress);
        $this->assertTrue(2 == $identifiers->count());        
    }     
    
    /**
     * @group domain_model_identifiers
     */
    public function testAddIdentifiersWithSameTypes()
    {
        $identifiers = new Identifiers();
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress);
        $this->assertTrue(1 == $identifiers->count());        
        $this->assertEquals($identifiers->current(), '02:42:b6:ca:7c:89');
    }     
    
    /**
     * @group domain_model_identifiers
     */
    public function testReferenceIdentifierByDefault()
    {
        $identifiers = new Identifiers();
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS, IdentifierTypes::LISTING);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress);        
        $this->assertTrue($serialNumber->equals($identifiers->referenceIdentifier()));
    }  
    
    /**
     * @group domain_model_identifiers
     */
    public function testReferenceIdentifierByDefinition()
    {
        $identifiers = new Identifiers();
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER, IdentifierTypes::LISTING);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS, IdentifierTypes::LISTING);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress, Identifiers::DEFAULT_IDENTIFIER);         
        $this->assertTrue($macAddress->equals($identifiers->referenceIdentifier()));
    }      
    
    /**
     * @group domain_model_identifiers
     */
    public function testIdentifiersInstantiationWithIdentifierTypes()
    {
        $identifiers = new Identifiers(IdentifierTypes::LISTING);
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress, Identifiers::DEFAULT_IDENTIFIER);         
        $this->assertTrue($macAddress->equals($identifiers->referenceIdentifier()));
    }    
    
    /**
     * @group domain_model_identifiers
     * @expectedException App\SystemDevices\Domain\Model\Device\Identifiers\IdentifierInvalidArgumentException
     */
    public function testIdentifiersInstantiationWithIdentifierTypesAndIdentifierWithWrongType()
    {
        $identifiers = new Identifiers(IdentifierTypes::LISTING);
        $serialNumber = Identifier::fromString('SN123896745', 'wrong_type');
        $identifiers->add($serialNumber);

    }    
    
    /**
     * @group domain_model_identifiers
     */
    public function testExistsIdentifier()
    {
        $identifiers = new Identifiers(IdentifierTypes::LISTING);
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS);
        $identifiers->add($serialNumber);         
        $this->assertTrue($identifiers->exist($serialNumber));
        $this->assertFalse($identifiers->exist($macAddress));
    }    
    
    /**
     * @group domain_model_identifiers
     */
    public function testChangeReferenceIdentifier()
    {
        $identifiers = new Identifiers(IdentifierTypes::LISTING);
        $serialNumber = Identifier::fromString('SN123896745', IdentifierTypes::SERIAL_NUMBER);
        $macAddress = Identifier::fromString('02:42:b6:ca:7c:89', IdentifierTypes::MAC_ADDRESS);
        $identifiers->add($serialNumber);
        $identifiers->add($macAddress);         
        $this->assertTrue($serialNumber->equals($identifiers->referenceIdentifier()));
        $identifiers->changeReferenceIdentifier($macAddress);
        $this->assertTrue($macAddress->equals($identifiers->referenceIdentifier()));
    }      
}
