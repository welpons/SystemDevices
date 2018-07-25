<?php

namespace App\SystemDevices\Infrastructure\DeviceIdentifiersFinders;

use App\SystemDevices\Domain\Model\Provider\Provider;

/**
 * Description of IdentifiersFinderFactory
 *
 * @author felix
 */
class IdentifiersFinderFactory 
{

    /**
     * Retrieves a finder object
     * 
     * @param mixed $deviceData
     * @param Phr_Device_Provider $provider
     * @param array $deviceTypeIds
     * @return Phr_Device_Finder_IdentifiersFinderInterface
     * @throws Phr_Device_Finder_IdentifiersFinderNotFoundException
     */
    public static function getFinder(Provider $provider) 
    {
        $providerFinderclassName = "App\SystemDevices\Infrastructure\IdentifiersFinder" . $provider->toString() . "DeviceIdentifiersFinder";

        if (class_exists($providerFinderclassName)) {
            return new $providerFinderclassName($provider);
        }

        throw new IndentifiersFinderNotFoundException(sprintf('Class to find identifiers in measurement payload does not exist: %s', $providerFinderclassName));
    }

}
