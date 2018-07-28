<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\SystemDevices\Infrastructure\Persistence\PDO;

/**
 * Description of PDOConnectionSettings
 *
 * @author felix
 */
class PDOConnectionSettings implements PDOConnectionSettingsInterface
{
    private $dsn;
    private $username;
    private $password;
    private $options = null;    
    
    public function __construct(string $dsn, string $username = null, string $password = null, array $options = null)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
        $this->options = $options;
    }    

    public function dsn() : string
    {
        return $this->dsn;
    }

    public function username() : string
    {
        return $this->username;
    }

    public function password() : string
    {
        return $this->password;
    }

    public function options()
    {
        return $this->options;
    }

    
    
}
