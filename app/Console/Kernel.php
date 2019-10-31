<?php
namespace App\Console;
use App\model\NewModel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Tools\Tools;
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
        $schedule->call(function(){
            $tools=new Tools;
            $url="http://www.mayansen.cn/new/new?name=奥巴马";
            $data=$tools->httpCurl($url);
            $data=json_decode($data,1);
            $NewData=NewModel::get()->toArray();
            Cache::store('redis')->put('NewData',$NewData,600);
        })->cron('* * * * *');
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
