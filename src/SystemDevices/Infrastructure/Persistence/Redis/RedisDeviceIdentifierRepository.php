<?php

namespace App\SystemDevices\Infrastructure\Persistence\Redis;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use Predis\ClientInterface;

/**
 * Description of RedisDeviceIdentifierRepository
 *
 * @author felix
 */
class RedisDeviceIdentifierRepository implements DeviceIdentifierRepositoryInterface
{    
    private $client;
    
    public function __construct(ClientInterface $client) 
    {
        $this->client = $client;
    }
    
    public function nextIdentity() : string
    {
        return (string) DeviceIdentifierId::create();
    }    
    
    public function deviceOfId(DeviceIdentifierId $id) : ?DeviceIdentifier
    {
        // TODO: Loop all
    }    
    
    public function deviceOfDeviceId(DeviceId $deviceId) : array
    {
        if ($values = $this->client->hgetall($deviceId->id())) {
            $deviceIdentifiers = [];
            $id = DeviceIdentifierId::create($values['id']);
            foreach ($this->getIdentifiers() as $type => $value) {
                $deviceIdentifiers[] = new DeviceIdentifier($id, $deviceId, Identifier::fromString($value, $type));
            } 
            
            return $deviceIdentifiers;
        }
        
        return [];
    }    
        
    public function deviceOfIdentifier(Identifier $identifier) : ?DeviceIdentifier
    {
        if ($values = $this->client->hgetall($identifier->value())) {
            $id = DeviceIdentifierId::create($values['id']);
            $deviceId = DeviceId::create($values['device_id']);
            return new DeviceIdentifier($id, $deviceId, Identifier::fromString($value, $type));
        }
        
        return null;
    }    
   
    public function add(DeviceIdentifier $deviceIdentifier)
    {
        if ($values = $this->client->hgetall($deviceIdentifier->deviceId()->id())) {
            if ($values['id'] == $deviceIdentifier->deviceIdentifierId()->id()) {
                throw new \Exception(sprintf('Duplicated device identifier identity: %s', $deviceIdentifier->deviceIdentifierId()->id()));
            }        
        }
        $this->client->hmset($deviceIdentifier->deviceId()->id(), $this->normalizeWithIndexDeviceId($deviceIdentifier));
        $this->client->hmset($deviceIdentifier->identifier()->value(), $this->normalizeWithIndexValue($deviceIdentifier));           
    }  
    
    public function update(DeviceIdentifier $deviceIdentifier)
    {
        if ($values = $this->client->hgetall($deviceIdentifier->identifier()->value())) {
            if ($values['id'] != $deviceIdentifier->deviceIdentifierId()->id()) {
                return;
            }
            $this->client->hmset($deviceIdentifier->deviceId()->id(), $this->normalizeWithIndexDeviceId($deviceIdentifier));
            $this->client->hmset($deviceIdentifier->identifier()->value(), $this->normalizeWithIndexValue($deviceIdentifier)); 
        }    
    }      
    
    public function remove(DeviceIdentifierId $deviceIdentifier)
    {
        $this->client->del($deviceIdentifier->id()->id());
       
    }        
    
    public function findBy(array $criteria)
    {
        
    }     
    
    private function normalizeWithIndexValue(DeviceIdentifier $deviceIdentifier)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            'device_id' => $deviceIdentifier->deviceId()->id(),
            'type' => $deviceIdentifier->identifier()->type(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];        
    }  
    
    private function normalizeWithIndexDeviceId(DeviceIdentifier $deviceIdentifier)
    {
        return [
            'id' => $deviceIdentifier->id()->id(),
            $deviceIdentifier->identifier()->type() => $deviceIdentifier->identifier()->value(),
            'is_reference' => (string) $deviceIdentifier->isReferenceIdentifier(),
            ];    
       
    }    
    
    private function getIdentifiers($values)
    {
        return array_filter($values, function($k) {
                return $k != 'id';
            }, ARRAY_FILTER_USE_KEY);
    }        
}
