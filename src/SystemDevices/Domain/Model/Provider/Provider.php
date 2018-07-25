<?php

namespace App\SystemDevices\Domain\Model\Provider;

/**
 * Value object: defines the message provider and its data format
 *
 * @author felix
 */
class Provider 
{
    const FORMAT_XML = 'xml';
    const FORMAT_JSON = 'json';
    
    /**
     *
     * @var string 
     */
    private $name;
    
    /**
     *
     * @var string 
     */
    private $format;
            
    public static function fromString(string $name, string $format, array $availableFormats = []): self
    {
        if(!empty($availableFormats) && !in_array(strtolower($format), $availableFormats)) {
            throw new InvalidProviderPayloadFormatException(sprintf('Wrong format. Available formats: %s', implode(',', $availableFormats)));
        }                 
        
        return new self($name, $format);
    }

    private function __construct(string $name, string $format)
    {
        if($name === '') {
            throw new InvalidProviderNameException("Name must not be an empty string");
        }
        
        if($name === '') {
            throw new InvalidProviderPayloadFormatException("Format must not be an empty string");
        }       
               
        
        $this->format = strtolower($format);
        $this->name = $name;
    }

    public function format()
    {
        return $this->format;
    }            
    
    public function name()
    {
        return $this->name;
    }      
    
    public function toString(): string
    {
        return $this->name;
    }

    public function equals($other): bool
    {
        if(!$other instanceof self) {
            return false;
        }

        return $this->name === $other->name && $this->format === $other->format;
    }

    public function __toString(): string
    {
        return $this->name;
    }    
}
