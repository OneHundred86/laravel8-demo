<?php

namespace App\Console\Commands\SMS;

use Illuminate\Console\Command;
use Oh86\SMS\Facades\SMS;

class SMSDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:demo';

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
        $this->tencentCloudDemo();

        return 0;
    }

    public function tencentCloudDemo()
    {
        // 腾讯云短信服务示例
        SMS::send(['15014153877', '15014153878'], ['123456']);
        // SMS::driver('tencentCloud')->send(['15014153877', '15014153878'], ['123456']);
        // SMS::driver('tencentCloud')->driver('default')->send(['15014153877', '15014153878'], ['123456']);
    }
}
