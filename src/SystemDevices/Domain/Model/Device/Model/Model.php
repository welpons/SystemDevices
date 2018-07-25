<?php


namespace App\SystemDevices\Domain\Model\Device\Model;

/**
 * Description of DeviceId
 *
 * @author felix
 */
class Model 
{
    private $id; 
    private $name;
    
    private function __construct(string $id = null, string $name = null) 
    { 
        $this->id = $id ?: uniqid(); 
        $this->name = $name;
    } 
    
    public static function create(string $id = null, string $name = null) 
    {
        return new static($id, $name);
    } 
    
    public function id() : string
    {
        return $this->id;
    }        
    
    public function name() : string
    {
        return $this->name;
    }        
    
    public function equals(Model $model) : bool
    { 
        return $this->id === $model->id() && $this->name === $model->name; 
    }    
    
    public function __toString() : string
    {
        return $this->id;
    }
}
