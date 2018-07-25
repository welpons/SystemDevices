<?php

namespace App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\QCL;

use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\AbstractIdentifiersFinder;
use App\SystemDevices\Infrastructure\DeviceIdentifiersFinders\IdentifiersFinderInterface;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers;
use App\SystemDevices\Domain\Model\Device\Identifiers\IdentifierTypes;

/**
 * Searches device identifiers inside measurements payload
 *
 * @author felix
 */
class QCLDeviceIdentifiersFinder extends AbstractIdentifiersFinder implements IdentifiersFinderInterface
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

        if (!isset($this->dataToProcess['qcl_json_data'])) {
            throw new QclDataNotFoundException('Undefined qcl data in payload');
        }
        
        if (is_string($this->dataToProcess['qcl_json_data'])) {
            $this->dataToProcess['qcl_json_data'] = $this->decodeJson($this->dataToProcess['qcl_json_data']);
        }         
       
        $identifiers = new Identifiers();        
        foreach(IdentifierTypes::LISTING as $identifierType) {
            $searchKey = $this->searchKey($identifierType);     
            $this->findIdentifiersByKey($identifiers, $identifierType, $searchKey);
        }
                
        return $identifiers;
    }
            
    /**
     * Retrieves a provider search key. 
     * 
     * @param string $identifierType standard identifier key
     * @return string
     */
    public function searchKey(string $identifierType) : string
    {
        $keys = [IdentifierTypes::SERIAL_NUMBER => 'device_serial_number', IdentifierTypes::MAC_ADDRESS => 'device_address', IdentifierTypes::HUB_ID => 'hub_id'];
        
        if (isset($keys[$identifierType])) {
            return $keys[$identifierType];
        }
        
        return ''; 
    }

}
