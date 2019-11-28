<?php
namespace App\Tools;
use Qiniu\Auth;
class Qiniu{
    private static $ak="ajV0zfSXB8f1G5Fk6qmv8rrtdezoEd-VEgKtEzXK";//
    private static $sk="vf1OOqXo2ZsvZig62COJ25XWMABPBFZ3pq0ORXM9";
    private static $back="mayansen";
    public static function token()
    {
        include "Qiniuskd/autoload.php";
         $obj=new Auth(self::$ak,self::$sk);
         $token=$obj->uploadToken(self::$back);
         return $token;
    }
}
