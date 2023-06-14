<?php

namespace App\Console\Commands;

use App\Jobs\UserConnectedJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UserConnected extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chat:user-connected';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Redis::subscribe(["userConnected"],function ($message){
            echo $message;
            dispatch(new UserConnectedJob($message));
        });
    }
}
