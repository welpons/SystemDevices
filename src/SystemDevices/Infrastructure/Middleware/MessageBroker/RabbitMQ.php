<?php


namespace App\SystemDevices\Infrastructure\Middleware\MessageBroker;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Description of RabbitMQ
 *
 * @author felix
 */
class RabbitMQ implements MessageBrokerInterface
{
    private $connection;
    private $channel;
    private $callback_queue;
    private $response;
    private $correlation_id;

    // On créer la connexion comme sur le serveur
    public function __construct(string $user, string $pass, string $host = 'localhost', int $port = 5672) 
    {
        $this->connection = new AMQPConnection($host, $port, $user, $pass);

        // On récupère ensuite le channel qui nous permet de communiquer avec RabbitMQ
         $this->channel = $this->connection->channel();

       // Création de la queue
       list($this->callback_queue, ,) = $this->channel->queue_declare(
            "", false, false, true, false);

       // Consommation de la queue en mode réponse
        $this->channel->basic_consume(
            $this->callback_queue, '', false, false, false, false,
            array($this, 'onResponse'));
    }

    // Varification de la correlation_id
    public function onResponse($rep) 
    {
        if($rep->get('correlation_id') == $this->correlation_id) {
            $this->response = $rep->body;
        }
    }

    // Publication dans la queue de notre message
    public function publish($n, $exchange = '',  $routingKey = '') 
    {
        $this->response = null;
        $this->correlation_id = uniqid();

        // Préparation du message avec demande de callback
        $msg = new AMQPMessage(
            (string) $n,
            array('correlation_id' => $this->correlation_id,
                  'reply_to' => $this->callback_queue)
            );

        // Publication du message dans la queue rpc
        $this->channel->basic_publish($msg, $exchange, $routingKey);

        return $this->response;
    }
}
