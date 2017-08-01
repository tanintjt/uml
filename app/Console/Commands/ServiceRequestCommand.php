<?php

namespace App\Console\Commands;

use Edujugon\PushNotification\Facades\PushNotification;
use Edujugon\PushNotification\Providers\PushNotificationServiceProvider;
use Illuminate\Console\Command;

class ServiceRequestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:request';

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
     * @return mixed
     */
    public function handle()
    {
        //PushNotification::test();

        echo "success";

    }
}
