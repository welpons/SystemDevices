<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use App\SystemDevices\Infrastructure\Projection\AsyncProjector;
use App\SystemDevices\Infrastructure\Middleware\MessageBroker\RabbitMQ;
use App\SystemDevices\Infrastructure\Persistence\PDO\PDODeviceIdentifierRepository;
use App\SystemDevices\Infrastructure\Persistence\PDO\Client as PDOClient;
use App\SystemDevices\Infrastructure\Persistence\PDO\PDOConnectionSettings;
use App\SystemDevices\Domain\Model\Device\DeviceIdentifier;

/**
 * Description of AdminDeviceIdentifiersController
 *
 * @author felix
 */
class AdminDeviceIdentifiersController 
{
    public function addIdentifier(Request $request, SerializerInterface $serializer)
    {
        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return Response('Invalid Content type');
        }
        $data = json_decode($request->getContent(), true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return Response('invalid json body: ' . json_last_error_msg());

        }
        
        $provider = new RabbitMQ('guest', 'guest');
        $projector = new AsyncProjector($provider, $serializer, 'hello');
        $connectionSettings = new PDOConnectionSettings('mysql:host=localhost;dbname=system_devices;charset=utf8', 'root', 'mallorca');
        $PDOClient = new PDOClient($connectionSettings);
        $repository = new PDODeviceIdentifierRepository($PDOClient, $projector);
        $deviceIdentifier = DeviceIdentifier::addNew(uniqid(), 'serial_number', 'SN1234');
        $repository->add($deviceIdentifier);
        
        return new Response('Ok');        
    }        
}
