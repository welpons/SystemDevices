<?php

namespace App\SystemDevices\Domain\Model\Device;

/**
 *
 * @author felix
 */
trait DeviceSubscriptionTrait 
{
    /**
     * @var App\SystemDevices\Domain\Model\Device\Subscription\Subscription 
     */
    protected $subscription;
    
    public function hasSubscription()
    {
        if (null === $this->subscription) {
            return false;
        }    
        
        return $this->subscription->hasSubscription();
    }        
    
    public function expirationDate()
    {
        if (null === $this->subscription) {
            return null;
        }         
        
        return $this->subscription->dateTo();
    }        
}
