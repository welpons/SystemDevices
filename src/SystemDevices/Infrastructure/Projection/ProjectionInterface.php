<?php



namespace App\SystemDevices\Infrastructure\Projection;

/**
 *
 * @author felix
 */
interface ProjectionInterface 
{
    public function project($event);
}
