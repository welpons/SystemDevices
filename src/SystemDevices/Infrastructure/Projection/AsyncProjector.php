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
    private $routingKey;

    public function __construct(MessageBrokerInterface $producer, SerializerInterface $serializer, string $routingKey = '') 
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
        $this->routingKey = $routingKey;
    }

    public function project(array $events) 
    {
        foreach ($events as $event) {
            $this->producer->publish(
                    $this->serializer->serialize(
                            $event, 'json'
                    ), '', $this->routingKey
            );
        }
    }

}
