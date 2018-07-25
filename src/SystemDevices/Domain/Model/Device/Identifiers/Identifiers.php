<?php

namespace App\SystemDevices\Domain\Model\Device\Identifiers;



/**
 * Description of identifiers
 *
 * @author felix
 */
class Identifiers implements \Iterator, \Countable 
{    
    const DEFAULT_IDENTIFIER = true;
    
    private $identifiers = [];
    private $referenceIdentifier;
    private $availableTypes;
    
    public function __construct(array $availableTypes = []) 
    {
        $this->availableTypes = $availableTypes;
    }
    
    public function add(Identifier $identifier, $isReferenceIdentifier = false)
    {
        if(!empty($this->availableTypes) && !in_array(strtolower($identifier->type()), $this->availableTypes)) {
            throw new IdentifierInvalidArgumentException(sprintf('Wrong identifier type. Available types: %s', implode(',', $this->availableTypes)));
        }          
        
        $this->identifiers[$identifier->type()] = $identifier;
       
        if (true === $isReferenceIdentifier) {
            $this->referenceIdentifier = $identifier;
        }
        
        if (1 == $this->count() && false === $isReferenceIdentifier) {
            $this->referenceIdentifier = $identifier;
        }
    }        
    
    public function addFromString(string $value, string $type, $isReferenceIdentifier = false)
    {       
        $identifier = Identifier::fromString($value, $type);          
        $this->add($identifier, $isReferenceIdentifier); 
    }        
    
    public function current() 
    {
        return current($this->identifiers);
    }

    public function key()
    {
        return key($this->identifiers);
    }

    public function next(): void 
    {
        next($this->identifiers);
    }

    public function rewind(): void 
    {
        reset($this->identifiers);
    }

    public function valid(): bool 
    {
        return $this->key() !== null;
    }

    public function count()
    {
        return count($this->identifiers);
    }     
    
    public function exist(Identifier $newIdentifier)
    {
        if (empty($this->identifiers)) {
            return false;
        }
        
        foreach($this->identifiers as $identifier) {
            if ($identifier == $newIdentifier) {
                return true;
            }
        }

        return false;
    }        
    
    public function referenceIdentifier()
    {
        return $this->referenceIdentifier;
    }        
    
    public function changeReferenceIdentifier(Identifier $refIdentifier)
    {
        if (!$this->exist($refIdentifier)) {
            $this->identifiers[$refIdentifier->type()] = $refIdentifier; 
        }
        
        $this->referenceIdentifier = $refIdentifier;
    }        
    
}
