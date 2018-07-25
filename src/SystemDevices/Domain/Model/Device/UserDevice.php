<?php

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\User\UserId;

/**
 * Description of UserDevice
 *
 * @author felix
 */
class UserDevice 
{
    use DeviceIdentityTrait;
    
    private $userId;
    
    public function __construct(DeviceId $id, UserId $userId) 
    {
        $this->id = $id;
        $this->userId = $userId;
    }
}
