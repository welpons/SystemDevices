<?php

namespace App\SystemDevices\Infrastructure\DeviceIdentifiersFinders;

use App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers;
use App\SystemDevices\Infrastructure\Util\SearchInArray;
/**
 * Description of AbstractIdentifiersFinder
 *
 * @author felix
 */
class AbstractIdentifiersFinder 
{
    protected $dataToProcess = [];
    
    /**
     * Data to process in array format
     * 
     * @return array
     */
    public function dataToProcress(): array 
    {
        return $this->dataToProcess;
    }    
    
    /**
     * Decodes a json object formatted
     * 
     * @param string $rawData
     * @return type
     * @throws FailedParsingPayloadException
     */
    protected function decodeJson(string $rawData)
    {
        $decodedData = json_decode($rawData, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new FailedParsingPayloadException('Impossible to decode json payload to array');
        }
        
        return $decodedData;
    }  
    


    /**
     * Searches devices identifiers in payload
     * 
     * @param Identifiers $identifiers
     * @param string $identifierType
     * @param string $search
     */
    protected function findIdentifiersByKey(Identifiers $identifiers, string $identifierType, string $search)
    {                
        if (empty($search)) {
            return;
        }
        
        $identifierBlock = SearchInArray::valueByKey($this->dataToProcess, $search);
        
        if (false !== $identifierBlock && !empty($identifierBlock) ) {            
            $identifiers->addFromString($identifierBlock, $identifierType);
        }         
    }         
    

    

    
}
