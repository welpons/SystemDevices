<?php

require __DIR__.'/../vendor/autoload.php';

use App\SystemDevices\Infrastructure\Middleware\Messaging\Queue;

$receiver = new Queue('guest', 'guest');
$receiver->listen('hello');


