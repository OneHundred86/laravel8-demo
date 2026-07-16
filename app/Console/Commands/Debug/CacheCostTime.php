<?php

namespace App\Console\Commands\Debug;

use Cache;
use Illuminate\Console\Command;

class CacheCostTime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:cache-cost-time {driver? : The cache driver}';

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
        $driver = $this->argument("driver");

        $startTime = microtime(true);

        // 10000次写
        for ($i = 0; $i < 10000; $i++) {
            Cache::driver($driver)->put("k1", "v1", 10);
        }

        // 10000次读
        for ($i = 0; $i < 10000; $i++) {
            $v = Cache::driver($driver)->get("k1");

            if ($v != "v1") {
                $this->error("error");
                return -1;
            }
        }

        // 统计总耗时
        $endTime = microtime(true);
        $this->info("cost time: " . ($endTime - $startTime));

        return 0;
    }
}
