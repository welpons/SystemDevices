<?php


namespace App\SystemDevices\Domain\Model\Device;


/**
 * Description of Device
 *
 * @author felix
 */
class RegisteredDevice implements DeviceStatusInterface
{
    use DeviceIdentityTrait;
    use DeviceIdentifiersTrait;
    use DeviceModelTrait;
    use DeviceSubscriptionTrait;
        

    /**
     *
     * @var \DateTimeInterface 
     */
    private $registeredAt;
    
    /**
     *
     * @var \DateTimeInterface 
     */
    private $updatedAt;

    /**
     *
     * @var \DateTimeInterface 
     */
    protected $deletedAt;
    
    
    /**
     * 
     * @param App\SystemDevices\Domain\Model\Device\DeviceId                  $id
     * @param App\SystemDevices\Domain\Model\Device\Model\ModelId             $modelId
     * @param \DateTime                                                             $registeredAt
     * @param App\SystemDevices\Domain\Model\Device\Subscription\Subscription $subscription
     */
    public function __construct(DeviceId $id, Model\ModelId $modelId, \DateTimeInterface $registeredAt, Subscription\Subscription $subscription = null)
    {
        $this->identifiers = new Identifiers\Identifiers();
        $this->id = $id;
        $this->modelId = $modelId;
        $this->registeredAt = $registeredAt;
        $this->subscription = $subscription;
    }

    public function registeredAt(): \DateTimeInterface
    {
        return $this->registeredAt;
    }

    public function updatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function deletedAt(): ?\DateTimeInterface
    {
        return $this->deletedAt;
    }
}
