<?php


namespace App\SystemDevices\Infrastructure\Persistence\PDO;

use App\SystemDevices\Domain\Model\Device\RegisteredDeviceRespositoryInterface;
use App\SystemDevices\Domain\Model\Device\RegisteredDevice;
use App\SystemDevices\Domain\Model\Device\DeviceId;
use App\SystemDevices\Infrastructure\Projection\ProjectorInterface;

/**
 * Description of PDORegisteredDeviceRepository
 *
 * @author felix
 */
class PDORegisteredDeviceRepository implements RegisteredDeviceRespositoryInterface
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
    
    public function add(RegisteredDevice $device) 
    {
        
    }

    public function deviceOfId(DeviceId $deviceId): ?RegisteredDevice 
    {
        
    }

    public function findBy(array $criteria) : array
    {
        
    }

    public function nextIdentity(): string 
    {
        
    }

    public function remove(DeviceId $device) 
    {
        
    }

    public function update(RegisteredDevice $device) 
    {
        
    }

}
