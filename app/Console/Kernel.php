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
            $url="http://api.avatardata.cn/ActNews/LookUp?key=3c458a7d3ee5421696c4e991b730958f";
            $data=$tools->httpCurl($url);
            $data=json_decode($data,1);
            foreach ($data['result'] as $value)
            {
                $url="http://api.avatardata.cn/ActNews/Query?key=3c458a7d3ee5421696c4e991b730958f&keyword={$value}";
                $new_data=$tools->httpCurl($url);
                $new_data=json_decode($new_data,1);
                foreach ($new_data['result'] as $v)
                {
                    $res=NewModel::where(['title'=>$v['title']])->first();
                    if(!$res)
                    {
                        NewModel::insert([
                            'title'=>$v['title'],
                            'content'=>$v['content'],
                            'pdate_src'=>$v['pdate_src'],
                            'src'=>$v['src'],
                            'pdate'=>$v['pdate'],
                        ]);
                    }
                }
            }
            $NewData=NewModel::get()->toArray();
            Cache::store('redis')->put('NewData',$NewData,60);
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
