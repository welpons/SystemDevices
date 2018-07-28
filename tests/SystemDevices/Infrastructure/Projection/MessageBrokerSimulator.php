<?php

namespace App\Tests\SystemDevices\Infrastructure\Projection;

use App\SystemDevices\Infrastructure\Middleware\MessageBroker\MessageBrokerInterface;

/**
 * Description of MessageBrokerSimulator
 *
 * @author felix
 */
class MessageBrokerSimulator implements MessageBrokerInterface
{
    public function publish($msg, $exchange = '', $routingKey = '') 
    {
        $event = json_decode($msg);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception;('Invalid json: ' . json_last_error_msg());
        }
        
        if (!isset($event->typeName)) {
            throw new \Exception;('Undefined "typeName"');
        }
        
        if (!isset($event->ocurredOn)) {
            throw new \Exception;('Undefined "ocurredOn"');
        }        
        
        echo sprintf('message: %s', $msg) . PHP_EOL;
    }

}
