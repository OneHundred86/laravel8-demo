<?php

namespace App\Console\Commands\Zip;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class ZipWithStorage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'zip:zipWithStorage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'zip demo：使用storage进行zip操作';

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
        $localZipPath = Storage::disk("tmp")->path("test.zip");
        $zip = new ZipArchive();
        if (($errCode = $zip->open($localZipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) !== true){
            throw new \Exception("创建zip文件失败，errCode: $errCode");
        }

        $files = Storage::files("/", true);
        foreach ($files as $file) {
            $filePath = Storage::path($file);
            $this->info($file . "\t" . $filePath);
            // $zip->addFile($filePath, $file);
            $zip->addFromString($file, Storage::get($file));
        }

        $zip->close();

        $this->info("zip文件: $localZipPath");

        return 0;
    }
}
