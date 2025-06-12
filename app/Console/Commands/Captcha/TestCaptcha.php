<?php

namespace App\Console\Commands\Captcha;

use Illuminate\Console\Command;
use Oh86\Captcha\Facades\Captcha;

class TestCaptcha extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'captcha:test';

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
        // $this->defaultDemo();
        $this->imageDemo();
        // $this->tencentCloudDemo();
        // $this->tencentCloudSmsDemo();

        return 0;
    }

    public function defaultDemo()
    {
        $capt = Captcha::acquire();
        var_dump($capt);

        $result = Captcha::verify(['key' => $capt['key'], 'value' => '1234']);
        var_dump($result);
    }

    public function imageDemo()
    {
        $capt = Captcha::driver('image')->acquire();
        var_dump($capt);

        $result = Captcha::driver('image')->verify(['key' => $capt['key'], 'value' => '1234']);
        var_dump($result);
    }

    public function tencentCloudDemo()
    {
        // $capt = Captcha::driver('tencentCloud')->acquire();
        // var_dump($capt);

        $result = Captcha::driver('tencentCloud')->verify(['ticket' => 'your_ticket_here', 'randStr' => 'your_rand_str_here', 'userIp' => 'your_user_ip_here']);
        var_dump($result);
    }

    public function tencentCloudSmsDemo()
    {
        // $key = Captcha::driver('sms')->acquire(['phone' => '15014153877']);
        $key = 'pf7dL5HrpHZWgvlwXO30jno7ASCRcos1';
        var_dump($key);

        $result = Captcha::driver('sms')->verify(['key' => $key, 'value' => '671179']);
        var_dump($result);
    }
}
