<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Infrastructure\DeviceIdentifiersFinders;

use App\SystemDevices\Domain\Model\Device\Identifiers\Identifiers;

/**
 *
 * @author felix
 */
interface IdentifiersFinderInterface 
{

    /**
     * Searches device identifiers into the $data structure:
     * serial number, mac address, etc.
     */
    public function findIdentifiers($rawData) : Identifiers;
    
    /**
     * Retrieves provider search key based on a standard type. 
     * These search keys are used to find out identifiers in the payload 
     * 
     * @param string $identifierType
     * @return array search array. 
     */
    public function searchKey(string $identifierType) : string;     
}
