<?php

namespace App\Console\Commands\Kafka;

use Illuminate\Console\Command;
use ThiagoBrauer\LaravelKafka\KafkaProducer;

class Producer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kafka:producer {msg}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $msg = $this->argument("msg");
        $this->info("send: $msg");

        $producer = new KafkaProducer();
        $producer->setTopic("test")
            ->send("from php: $msg");

        return 0;
    }
}
