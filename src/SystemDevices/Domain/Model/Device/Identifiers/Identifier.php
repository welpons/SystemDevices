<?php

namespace App\SystemDevices\Domain\Model\Device\Identifiers;

/**
 * Description of Identifier
 *
 * @author felix
 */
class Identifier 
{
    /**
     *
     * @var string 
     */
    private $type;
    
    /**
     *
     * @var string 
     */
    private $value;
            
    public static function fromString(string $value, string $type): self
    {        
        return new self($value, $type);
    }

    private function __construct(string $value, string $type)
    {
        if($type === '') {
            throw new IdentifierInvalidArgumentException("Device identifier type must not be an empty string");
        }
        
        if($value === '') {
            throw new IdentifierInvalidArgumentException("Value must not be an empty string");
        }       
               
        
        $this->type = strtolower($type);
        $this->value = $value;
    }

    public function value()
    {
        return $this->value;
    }            
    
    public function type()
    {
        return $this->type;
    }      
    
    public function toString(): string
    {
        return $this->value;
    }

    public function equals($other): bool
    {
        if(!$other instanceof self) {
            return false;
        }

        return $this->type === $other->type && $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }        
}
