<?php

namespace App\Console\Commands\Hash;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hash:demo';

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
        // $this->bcryptHashDemo();
        $this->localHmacSm3HashDemo();

        return 0;
    }

    public function bcryptHashDemo()
    {
        $en = Hash::driver('bcrypt')->make('123456');

        /** @var bool */
        $result = Hash::driver('bcrypt')->check('123456', $en);

        var_dump($en, $result);
    }

    public function localHmacSm3HashDemo()
    {
        $en = Hash::driver('localHmacSm3')->make('123456');
        /** @var bool */
        $result = Hash::driver('localHmacSm3')->check('123456', $en);
        var_dump($en, $result);
    }
}
