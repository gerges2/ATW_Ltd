<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class callApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:call-api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'call api from anther application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $response = Http::get('https://randomuser.me/api/');     
        if ($response->successful()) {
            echo $response;
        } else {
            echo 'nota data fatch';

        }
    }
}
