<?php

namespace App\SystemDevices\Infrastructure\Middleware\Messaging;

use PhpAmqpLib\Connection\AMQPConnection;

/**
 * Description of Consumer
 *
 * @author felix
 */
class Queue 
{
    
    private $connection;
    
    public function __construct(string $user, string $pass, string $host = 'localhost', int $port = 5672) 
    {
        $this->connection = new AMQPConnection($host, $port, $user, $pass);
    }

    /**
     * Listens for incoming messages
     */
    public function listen(string $queueName) {


        $channel = $this->connection->channel();

        $channel->queue_declare(
                $queueName, #queue name, the same as the sender
                false, #passive
                false, #durable
                false, #exclusive
                false  #autodelete
        );      
        
        $channel->basic_consume($queueName, '', false, true, false, false, array($this, 'processOrder'));   #callback - method that will receive the message


        while (count($channel->callbacks)) {
            $channel->wait();
        }

        $channel->close();
        $this->connection->close();
    }

    /**
     * @param $msg
     */
    public function processOrder($msg) 
    {
        echo ' [x] Received ', $msg->body, "\n";     
    }

}
