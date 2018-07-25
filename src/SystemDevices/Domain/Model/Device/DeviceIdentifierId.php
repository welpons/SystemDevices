<?php

namespace App\SystemDevices\Domain\Model\Device;

/**
 * Description of Identity
 *
 * @author felix
 */
class DeviceIdentifierId 
{
    private $id; 
    
    private function __construct(string $id = null) 
    { 
        $this->id = $id ?: uniqid(); 
    } 
    
    public static function create(string $id = null) 
    {
        return new static($id);
    } 
    
    public function id()
    {
        return $this->id;
    }        
    
    public function equals(DeviceIdentifierId $deviceIdentifierId) 
    { 
        return $this->id === $deviceIdentifierId->id(); 
    }    
    
    public function __toString()
    {
        return $this->id;
    }
}
