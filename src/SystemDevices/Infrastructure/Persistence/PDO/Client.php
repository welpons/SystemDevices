<?php

namespace App\SystemDevices\Infrastructure\Persistence\PDO;

/**
 * Description of Client
 *
 * @author felix
 */
class Client extends \PDO
{   
    public function __construct(PDOConnectionSettingsInterface $ConnectionSettings)
    {
        parent::__construct($ConnectionSettings->dsn(), $ConnectionSettings->username(), $ConnectionSettings->password(), $ConnectionSettings->options());
    }
}
