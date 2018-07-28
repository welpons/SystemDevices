<?php

namespace App\SystemDevices\Infrastructure\Persistence\PDO;

use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierId;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Infrastructure\Projection\ProjectorInterface;

/**
 * Description of PDODeviceIdentifierRepository
 *
 * @author felix
 */
class PDODeviceIdentifierRepository implements DeviceIdentifierRepositoryInterface
{
    /**
     * @var PDO
     */
    private $pdo;
    private $projector;

    public function __construct(Client $pdo, ProjectorInterface $projector)
    {
        $this->pdo = $pdo;
        $this->projector = $projector;
    }
    
    public function nextIdentity() : string
    {
        return (string) DeviceIdentifierId::create();
    }    
    
    public function deviceOfId(DeviceIdentifierId $id) : ?DeviceIdentifier
    {
        $stmt = $this->pdo->prepare('SELECT * FROM device_identifiers WHERE id = :id');
        $stmt->bindValue(':id', (string) $id, \PDO::PARAM_STR);
        $stmt->execute();

        if($stmt->rowCount()) {
            while ($row = $stmt->fetch(PDOQueryService::FETCH_ASSOC)) {
                $deviceId = DeviceId($row['device_id']);
                $identifier = Identifier::fromString($row['value'], $row['type']);
                $isReference = (bool) $row['is_reference'];
            }

            return new DeviceIdentifier($id, $deviceId, $identifier, $isReference);
        } else {
              return null;
        }        
        

        
    }
    
    public function deviceOfDeviceId(DeviceId $deviceId) : array
    {
        $stmt = $this->pdo->query('SELECT * FROM device_identifiers where device_id = :device_id');
        $stmt->bindValue(':device_id', (string) $deviceId, \PDO::PARAM_STR);        
        $stmt->execute();

        $deviceIdentifiers = [];

        while ($row = $stmt->fetch(PDOQueryService::FETCH_ASSOC)) {
            $deviceIdentifiers[] = new DeviceIdentifier(
                DeviceIdentifierId::create($row['id']),
                DeviceId::create($row['device_id']),
                Identifier::fromString($row['value'], $row['type']),
                $row['is_reference']
            );
        }

        return $deviceIdentifiers;      
    }    
        
 
   
    public function add(DeviceIdentifier $deviceIdentifier)
    {
        $stmt = $this->pdo->prepare(
            'INSERT INTO device_identifiers (id, device_id, type, value, is_reference)
             VALUES (:id, :device_id, :type, :value, :is_reference)'
        );

        $stmt->execute([
            ':id' => (string) $deviceIdentifier->id(),
            ':device_id'   => (string) $deviceIdentifier->deviceId(),
            ':type' => $deviceIdentifier->identifier()->type(),
            ':value'   => $deviceIdentifier->identifier()->value(),
            ':is_reference'   => $deviceIdentifier->isReferenceIdentifier(),
        ]);
        
        $this->projector->project($deviceIdentifier->recordedEvents());
    }        
    
    public function update(DeviceIdentifier $deviceIdentifier)
    {
        $stmt = $this->pdo->prepare(
            'UPDATE posts SET state = :state WHERE post_id = :post_id'
        );

        $stmt->execute([
            ':state'    => PostStates::STATE_PUBLISHED,
            ':post_id'  => $event->getAggregateId()
        ]);        
    }
    
    public function remove(DeviceIdentifierId $id)
    {
        $stmt = $this->pdo->prepare(
            'DELETE FROM device_identifiers WHERE id = :id'
        );

        $stmt->execute([
            ':id'    => (string) $id,
        ]);          
    }
        
    
  
}
