<?php


namespace App\SystemDevices\Domain\Model\Device;

/**
 * Description of DeviceId
 *
 * @author felix
 */
class DeviceId 
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
    
    public function equals(DeviceId $deviceId) 
    { 
        return $this->id === $deviceId->id(); 
    }    
    
    public function __toString()
    {
        return $this->id;
    }
}
