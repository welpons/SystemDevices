<?php



namespace App\SystemDevices\Infrastructure\Projection;

use App\SystemDevices\Infrastructure\Middleware\MessageBroker\MessageBrokerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Description of AsyncProjector
 *
 * @author felix
 */
class AsyncProjector implements ProjectorInterface
{
    private $producer;
    private $serializer;
    private $queue;

    public function __construct(MessageBrokerInterface $producer, SerializerInterface $serializer) 
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
        $this->queue = '';
    }

    public function project(array $events) 
    {
        foreach ($events as $event) {
            $this->producer->publish(
                    $this->serializer->serialize(
                            $event, 'json'
                    ), '', $this->queue
            );
        }
    }

    public function setQueue(string $queue)
    {
        $this->queue = $queue;
    }        
}
