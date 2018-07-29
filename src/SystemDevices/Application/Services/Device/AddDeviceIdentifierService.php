<?php

namespace App\SystemDevices\Application\Services\Device;

use App\SystemDevices\Domain\Model\Device\RegisteredDeviceRespositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;
use App\SystemDevices\Application\Common\ApplicationServiceInterface;

/**
 * Description of AddDeviceIdentifierService
 *
 * @author felix
 */
class AddDeviceIdentifierService implements ApplicationServiceInterface
{
    private $registeredDeviceRepository;
    private $deviceIdentifierRepository;
    
    public function __construct(RegisteredDeviceRespositoryInterface $registeredDeviceRepository, 
            DeviceIdentifierRepositoryInterface $deviceIdentifierRepository) 
    {
        $this->registeredDeviceRepository = $registeredDeviceRepository;
        $this->deviceIdentifierRepository = $deviceIdentifierRepository;
    }

    public function handle($dto) 
    {
        // TODO: Validation (dto paramters + device_id in DB
        
        $deviceIdentifier = DeviceIdentifier::addNew($dto->device_id, $dto->type, $dto->value);
        $this->deviceIdentifierRepository->add($deviceIdentifier);        
    }

}
