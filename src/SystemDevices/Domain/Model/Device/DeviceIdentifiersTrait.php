<?php


namespace App\SystemDevices\Domain\Model\Device;

/**
 *
 * @author felix
 */
trait DeviceIdentifiersTrait 
{
    /**
     *
     * @var App\SystemDevices\Domain\Model\Device\Identifiers\Identifier
     */
    private $referenceIdentifier;

    /**
     *
     * @var App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers
     */
    private $identifiers;
    
    /**
     * 
     * @param \App\SystemDevices\Domain\Model\Device\Identifier $identifier
     * @param boolean $isReferenceIdentifier
     */
    public function addIdentifier(Identifiers\Identifier $identifier, $isReferenceIdentifier = false)
    {
        $this->identifiers->add($identifier, $isReferenceIdentifier);
    }        
    

    public function changeReferenceIdentifier(Identifiers\Identifier $identifier)
    {
        $this->identifiers->changeReferenceIdentifier($identifier);
    }   

    public function identifiers(): Identifiers\Identifiers
    {
        return $this->identifiers;
    }

    public function getReferenceIdentifier(): Identifiers\Identifier
    {
        return $this->identifiers->referenceIdentifier();
    }    
}
