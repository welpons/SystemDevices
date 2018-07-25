<?php

namespace App\SystemDevices\Application\Services\ProcessPayload;

use App\SystemDevices\Domain\Model\UserDevice\UserDevicesRepositoryInterface;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifierRepositoryInterface;
use App\SystemDevices\Command\MeasurementCommand;

/**
 * This service is in charge to 
 *
 * @author felix
 */
class ProcessPayloadService 
{
    private $userDeviceRepository;
    private $deviceIdentifierRepository;
    private $identifiersFinderFactory;
    private $measurementsBus;
    
    public function __construct(DeviceIdentifierRepositoryInterface $deviceIdentifierRepository, 
            UserDevicesRepositoryInterface $userDevicesRepository, 
            $identifiersFinderFactory,
            MeasurementsBus $measurementsBus) // 
    {
        $this->userDeviceRepository = $userDevicesRepository;
        $this->deviceIdentifierRepository = $deviceIdentifierRepository;
        $this->identifiersFinderFactory = $identifiersFinderFactory;
        $this->measurementsBus = $measurementsBus;
    }              
    
    public function process(PayloadDTO $payloadDTO)
    {
        try {
            // extract $identifiers from DTO
            $identifiersFinder = $this->identifiersFinderFactory->getFinder($payloadDTO->provider());
            $identifiers = $identifiersFinder->findIdentifiers($payloadDTO->rawPayload());

            // TODO: pending check if a device exist with found identifiers
            $registeredDevice = $this->deviceIdentifierRepository->deviceWith($identifiers);
            
            
            if (!$registeredDevice->hasSubscription()) {
                // TODO: Exception
            }
            
            $userDevice = $this->userDeviceRepository->find($registeredDevice->id());

            if (null === $userDevice) {
                // TODO: Exception     
            }  
            $measurementCommand = new MeasurementCommand($payloadDTO->provider(), $userDevice, $payloadDTO->rawPayload(), $payloadDTO->receivingTime());
            
            $this->measurementsBus->dispatch($measurementCommand);
        } catch (Exception $ex) {

        }

    }    
}
