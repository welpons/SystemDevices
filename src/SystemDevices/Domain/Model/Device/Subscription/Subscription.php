<?php


namespace App\SystemDevices\Domain\Model\Device\Subscription;


/**
 * Description of Subscription
 *
 * @author felix
 */
class Subscription 
{
    /**
     *
     * @var \DateTime 
     */
    private $dateFrom;
    
    /**
     *
     * @var \DateTime 
     */    
    private $dateTo;

    private function __construct(\DateTimeImmutable $dateFrom, \DateTimeInterface $dateTo) 
    {
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }
    
    public static function create(\DateTimeImmutable $dateFrom, \DateTimeInterface $dateTo) 
    {
        if ($dateFrom >= $dateTo) {
            throw new WrongSubscriptionDatesException(sprintf('"Date to" must be greater than "Date from"'));
        }
        
        return new static($dateFrom, $dateTo);
    }     
    
    public function isDateTimeWithinPeriodOfActivity(string $dateTime = null) : bool
    {
        if (null === $dateTime) {
            $dateTime = new DateTime();
        } else {
            $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $dateTime);
        }

        if (!is_null($this->dateFrom)) {
            if ($dateTime < $this->dateFrom) {
                return false;
            }
        }
        if (!is_null($this->dateTo)) {
            $this->dateTo->add(new DateInterval('P1D'));

            if ($dateTime >= $this->dateTo) {
                return false;
            }
        }

        return true;
    }
    
    public function hasSubscription() : bool
    {
        return $this->isDateTimeWithinPeriodOfActivity();
    }        
    
    function dateFrom() : \DateTimeImmutable
    {
        return $this->dateFrom;
    }

    function dateTo() : \DateTimeImmutable
    {
        return $this->dateTo;
    }

    public function equals(Subscription $subscription) : bool
    { 
        return $this->dateFrom === $subscription->dateFrom && $this->dateTo === $subscription->dateTo; 
    }   
}
