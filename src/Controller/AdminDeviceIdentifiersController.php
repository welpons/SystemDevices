<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\SystemDevices\Infrastructure\Projection\AsyncProjector;
use App\SystemDevices\Infrastructure\Middleware\MessageBroker\RabbitMQ;
use Symfony\Component\Serializer\SerializerInterface;

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
        $projector = new AsyncProjector($provider, $serializer);
        
        return new Response('Ok');        
    }        
}
