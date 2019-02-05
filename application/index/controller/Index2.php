<?php
namespace app\index\controller;
use app\common\lib\ali\Sms;
class Index
{
    public function index()
    {
        print_r($_GET);
        echo 'singwa-hello';
    }

    public function singwa() {
        echo time();
    }

    public function hello($name = 'ThinkPHP5')
    {
        return 'hello,' . $name;
    }
    public function sms() {
        try {
            Sms::sendSms(18618158941, 12345);
        }catch (\Exception $e) {
            // todo
            echo $e->getMessage();
        }

    }
}
