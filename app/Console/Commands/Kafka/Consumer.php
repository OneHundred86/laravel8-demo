<?php

namespace App\Console\Commands\Kafka;

use ThiagoBrauer\LaravelKafka\Handlers\MessageHandler;
use RdKafka\Message;
class Consumer extends MessageHandler
{

    public function handle(Message $message)
    {
        var_dump($message);
    }
}
