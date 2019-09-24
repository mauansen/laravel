<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
//        $schedule->call(function(){
//            DB::table('login')->insert(['tel'=>123,'pwd'=>123]);
//        })->cron('* * * * *');
        $schedule->call(function(){

            $data=DB::table('wechat_user')->get();
            foreach($data as $v){
                if($v->or_sign==2)
                {
                    DB::table('wechat_user')->update([
                        'sign'=>'0'
                    ]);
                }
            }
            DB::table('wechat_user')->update([
                'or_sign'=>2
            ]);
        })->cron('5 * * * *');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
