<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Domain\Model\Device;

use App\SystemDevices\Domain\Model\Device\Identifiers\Identifier;
use App\SystemDevices\Domain\Model\Device\DeviceId;

/**
 *
 * @author felix
 */
interface RegisteredDeviceRespositoryInterface
{
    public function nextIdentity() : string;
    
    public function deviceOfId(DeviceId $deviceId) : ?RegisteredDevice;
   
    public function add(RegisteredDevice $device); 
    
    public function update(RegisteredDevice $device);
    
    public function remove(RegisteredDevice $device);
    
    public function findBy(array $criteria);
}
