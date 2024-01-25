<?php

namespace App\ContainerTest\Commands;

use App\ContainerTest\TestInterface;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'container:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '测试容器';

    /**
     * @var TestInterface
     */

    protected $test;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(TestInterface $test)
    {
        parent::__construct();
        $this->test = $test;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        var_dump(__METHOD__, $this->test->get());

        // 下面这种办法注入，when起不到作用；
        // $test = app(TestInterface::class);

        return 0;
    }
}
