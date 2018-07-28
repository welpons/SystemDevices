<?php

namespace App\SystemDevices\Infrastructure\Projection;

/**
 * Description of ProjectorInterface
 *
 * @author felix
 */
interface ProjectorInterface 
{
    public function project(array $events);
}
