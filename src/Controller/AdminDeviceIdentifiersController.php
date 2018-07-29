<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\SystemDevices\Infrastructure\Projection\AsyncProjector;
use App\SystemDevices\Infrastructure\Persistence\PDO\PDODeviceIdentifierRepository;
use App\SystemDevices\Infrastructure\Persistence\PDO\PDORegisteredDeviceRepository;
use App\SystemDevices\Infrastructure\Persistence\PDO\Client;

use App\SystemDevices\Application\Services\Device\AddDeviceIdentifierService;

/**
 * Description of AdminDeviceIdentifiersController
 *
 * @author felix
 */
class AdminDeviceIdentifiersController 
{
    public function addIdentifier(Request $request, AsyncProjector $projector, Client $PDOClient)
    {
        if ($request->getContentType() != 'json' || !$request->getContent()) {
            return Response('Invalid Content type');
        }
        $dtoDeviceIdentifier = json_decode($request->getContent());
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            return Response('invalid json body: ' . json_last_error_msg());

        }    
        
        $projector->setQueue('hello');
        $service = new AddDeviceIdentifierService(new PDORegisteredDeviceRepository($PDOClient, $projector),
                new PDODeviceIdentifierRepository($PDOClient, $projector));        
        $service->handle($dtoDeviceIdentifier);
        
        return new Response('Ok');        
    }        
}
