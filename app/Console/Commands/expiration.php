<?php

namespace App\Console\Commands;

use App\Models\posts;
use Illuminate\Console\Command;
use Carbon\Carbon;
class expiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:expiration';//اي اسم عادي

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'will deleted all post deleted before 30 days'; 

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $date = Carbon::now()->subDays(30);
         return         
         response( posts::onlyTrashed()
             ->where('deleted_at', '>', $date)
             ->forceDelete());
     
    }
}
