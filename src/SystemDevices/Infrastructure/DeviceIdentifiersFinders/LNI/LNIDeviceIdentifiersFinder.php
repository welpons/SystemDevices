<?php

namespace App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\LNI;

use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\AbstractIdentifiersFinder;
use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\IdentifiersFinderInterface;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers;
use App\SystemDevices\Domain\Model\Device\Identifiers\IdentifierTypes;

/**
 * Searches device identifiers inside measurements payload
 *
 * @author felix
 */
class LNIDeviceIdentifiersFinder extends AbstractIdentifiersFinder implements IdentifiersFinderInterface
{
    /**
     * Finds device identifiers in payload
     * 
     * @param mixed $rawData
     * @return Identifiers
     * @throws QclDataNotFoundException
     */
    public function findIdentifiers($rawData): Identifiers 
    {
        $this->dataToProcess = $rawData;
        
        if (is_string($rawData)) {
            $this->dataToProcess = $this->decodeJson($rawData);
        }        
              
        $identifiers = new Identifiers();        
        foreach(IdentifierTypes::LISTING as $identifierType) {
            $key = $this->searchKey($identifierType);     
            $this->findIdentifiersByKey($identifiers, $identifierType, $key);
        }
                
        return $identifiers;
    }
            
    /**
     * Retrieves provider key
     * 
     * @param string $identifierType standard identifier key
     * @return string
     */
    public function searchKey(string $identifierType) : string
    {
        $keys = [IdentifierTypes::SERIAL_NUMBER => 'device.systemIds.0.universalId', IdentifierTypes::MAC_ADDRESS => 'device.systemIds.1.universalId', IdentifierTypes::HUB_ID => 'ahd.systemId.universalId'];
        
        if (isset($keys[$identifierType])) {
            return $keys[$identifierType];
        }
        
        return '';
    }

}
