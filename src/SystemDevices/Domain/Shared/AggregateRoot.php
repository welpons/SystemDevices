<?php

namespace App\SystemDevices\Domain\Shared;

/**
 * Description of AggregateRoot
 *
 * @author felix
 */
class AggregateRoot {

    private $recordedEvents = [];

    protected function recordApplyAndPublishThat(DomainEvent $domainEvent) 
    {
        $this->recordThat($domainEvent);
        //$this->applyThat($domainEvent);
        //$this->publishThat($domainEvent);
    }

    protected function recordThat(DomainEvent $domainEvent) 
    {
        $this->recordedEvents[] = $domainEvent;
    }

//    protected function applyThat(DomainEvent $domainEvent) 
//    {
//        $modifier = 'apply' . get_class($domainEvent);
//        $this->$modifier($domainEvent);
//    }
//
//    protected function publishThat(DomainEvent $domainEvent) 
//    {
//        DomainEventPublisher::getInstance()->publish($domainEvent);
//    }

    public function recordedEvents() 
    {
        return $this->recordedEvents;
    }

    public function clearEvents() 
    {
        $this->recordedEvents = [];
    }

}
