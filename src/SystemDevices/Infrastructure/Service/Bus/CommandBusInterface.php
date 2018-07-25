<?php

namespace App\SystemDevices\Infrastructure\Service\Bus;

/**
 * Description of CommandBus
 *
 * @author felix
 */
interface CommandBusInterface 
{
     public function register($aCommandHandler);
     public function handle($aCommand);
}
