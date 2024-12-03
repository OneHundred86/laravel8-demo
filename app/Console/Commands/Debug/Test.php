<?php

namespace App\Console\Commands\Debug;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:test {arg1?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'debug测试';

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
        $arg1 = $this->argument("arg1");

        $a = $arg1;

        $b = $a;


        $log = Log::channel("daily");
        $log->debug(__METHOD__, compact("a", "b"));

        return 0;
    }
}
