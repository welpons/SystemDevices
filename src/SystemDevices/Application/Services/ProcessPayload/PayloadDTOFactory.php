<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Application\Services\ProcessPayload;

/**
 * Description of PayloadDTOFactory
 *
 * @author felix
 */
class PayloadDTOFactory 
{
    public static function generate($payload, string $providerName) : PayloadDTO
    {
        $finder = IdentifiersFinderFactory::getFinder($providerName); 
        
        $identifiers = $finder->findIdentifiers($payload);
        
        if (empty($identifiers)) {
            // TODO: Exception            
        }
        
      
    }        
}
