<?php

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConsumeOrder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function consume(){
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $callback = function ($msg) {
            $data = json_decode($msg->body, true);
            $this->processMessage($data);
        };
        $channel->queue_declare('test_queue', false, false, false, false);
        $channel->basic_consume('test_queue', '', false, true, false, false, $callback);
        echo 'Waiting for new message on test_queue', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }

     private function processMessage($data)
    {
        return $data;
    }
}
