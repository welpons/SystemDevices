<?php


namespace App\SystemDevices\Domain\Model\Device\Model;

/**
 * Description of DeviceId
 *
 * @author felix
 */
class ModelId 
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
    
    public function equals(ModelId $modelId) 
    { 
        return $this->id === $modelId->id(); 
    }    
    
    public function __toString()
    {
        return $this->id;
    }
}
