<?php



namespace App\SystemDevices\Infrastructure\Projection;

use App\SystemDevices\Infrastructure\Middleware\MessageBroker\MessageBrokerInterface;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * Description of AsyncProjector
 *
 * @author felix
 */
class AsyncProjector 
{
    private $producer;
    private $serializer;

    public function __construct(MessageBrokerInterface $producer, SerializerInterface $serializer) 
    {
        $this->producer = $producer;
        $this->serializer = $serializer;
    }

    public function project(array $events) 
    {
        foreach ($events as $event) {
            $this->producer->publish(
                    $this->serializer->serialize(
                            $event, 'json'
                    )
            );
        }
    }

}
