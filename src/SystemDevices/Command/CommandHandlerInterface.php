<?php

namespace App\SystemDevices\Command;

/**
 *
 * @author felix
 */
interface CommandHandlerInterface 
{
    public function handle(CommandHandlerInterface $command);
}
