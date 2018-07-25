<?php

namespace App\SystemDevices\Domain\Model\Device;

/**
 * Description of DeviceStatuses
 *
 * @author felix
 */
interface DeviceStatusInterface
{
    const STATUS_CONN_ACTIVE = 1;
    const STATUS_CONN_INACTIVE = 0;
    const STATUS_CONN_UNKNOWN = 9;  

}
