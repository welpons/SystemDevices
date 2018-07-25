<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Application\Services\ProcessPayload;

use App\SystemDevices\Application\Services\DTOInterface;
use App\SystemDevices\Domain\Model\Provider\Provider;

/**
 * Description of PayloadDTO
 *
 * @author felix
 */
class PayloadDTO implements DTOInterface
{
    /**
     *
     * @var mixed 
     */
    private $rawPayload;
    
    /**
     *
     * @var App\SystemDevices\Domain\Model\Provider\Provider 
     */
    private $provider;
    
    /**
     *
     * @var \DateTime 
     */
    private $receivingTime;
    
    function __construct($rawPayload, Provider $provider) 
    {
        $this->rawPayload = $rawPayload;
        $this->provider = $provider;
        $this->getReceivingTime = new \DateTimeImmutable();
    }

    function rawPayload() 
    {
        return $this->rawPayload;
    }

    function provider(): Provider 
    {
        return $this->provider;
    }

    function receivingTime(): \DateTime 
    {
        return $this->receivingTime;
    }


}
