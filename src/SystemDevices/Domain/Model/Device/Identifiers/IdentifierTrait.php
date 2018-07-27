<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Domain\Model\Device\Identifiers;

/**
 *
 * @author felix
 */
trait IdentifierTrait 
{
    private $identifier;
    
    public function identifier() : Identifier
    {
        return $this->identifier;
    }    
}
