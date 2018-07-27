<?php


namespace App\SystemDevices\Infrastructure\Persistence\PDO;

/**
 * Description of PDOConnectionSettingsInterface
 *
 * @author felix
 */
interface PDOConnectionSettingsInterface
{
    function dsn() : string;
    function username() : string;
    function password() : string;
    function options();

}
