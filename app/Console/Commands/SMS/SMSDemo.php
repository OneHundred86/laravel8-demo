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
        // $this->tencentCloudDemo();
        $this->extendServiceDemo();
        // $this->extendDriverDemo();

        return 0;
    }

    public function tencentCloudDemo()
    {
        // 腾讯云短信服务示例
        // SMS::send(['15014153877', '15014153878'], ['123456']);

        SMS::driver('tencentCloudApp')->send(['15014153877', '15014153878'], ['123456']);
    }

    public function extendServiceDemo()
    {
        app()->get(\Oh86\SMS\SMSManager::class)->extendService('serviceDemo', function ($config, $app): \Oh86\SMS\Services\SMSServiceInterface {
            return new DemoSMSService($config);
        });

        SMS::driver('serviceDemoApp')->send(['15014153877', '15014153878'], ['123456']);
    }

    public function extendDriverDemo()
    {
        app()->get(\Oh86\SMS\SMSManager::class)->extend('driverDemo', function ($app): \Oh86\SMS\Services\SMSServiceInterface {
            $config = $app->make('config')->get('sms.drivers.driverDemo');
            return new DemoSMSService($config);
        });

        SMS::driver('driverDemo')->send(['15014153877', '15014153878'], ['123456']);
    }
}





class DemoSMSService implements \Oh86\SMS\Services\SMSServiceInterface
{
    private array $config;

    public function __construct($config)
    {
        $this->config = $config;
    }


    public function send($phones, $templateParams = [], $options = [])
    {
        var_dump(__METHOD__, $this->config, $phones, $templateParams, $options);
    }
}
