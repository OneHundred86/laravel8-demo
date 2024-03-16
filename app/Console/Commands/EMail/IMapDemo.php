<?php

namespace App\Console\Commands\EMail;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;

class IMapDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:imap';

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
        $client = Client::account('default');

        //Connect to the IMAP Server
        $client->connect();

        //Get all Mailboxes
        /** @var \Webklex\PHPIMAP\Support\FolderCollection $folders */
        $folders = $client->getFolders();

        //Loop through every Mailbox
        /** @var \Webklex\PHPIMAP\Folder $folder */
        foreach($folders as $folder){
            $this->info("folder-name: $folder->name");
            // continue;

            //Get all Messages of the current Mailbox $folder
            /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
            // $messages = $folder->messages()->all()->get();
            // $messages = $folder->messages()->unseen()->get();
            $messages = $folder->messages()->since("2024-03-01")->get();

            /** @var \Webklex\PHPIMAP\Message $message */
            foreach($messages as $message){
                echo $message->getSubject()."\n";
                echo $message->getDate() . "\n";
                echo 'Attachments: '.$message->getAttachments()->count()."\n";
                // echo trim($message->getTextBody()) . "\n";
                echo "mask: " . $message->getMask() . "\n";
                echo "messageId:" . $message->getMessageId() . "\n";
                echo "messageNo:" . $message->getMessageNo() . "\n";

                //Move the current Message to 'INBOX.read'
                // if($message->move('INBOX.read') == true){
                //     echo "Message has ben moved \n";
                // }else{
                //     echo "Message could not be moved \n";
                // }

                echo "\n\n";
            }
        }


        return 0;
    }
}
