<?php
namespace app\admin\controller;
use app\common\lib\Util;

class Image
{

    public function index() {

//        $file = request()->file('file');
        $info = move_uploaded_file($_FILES["file"]["tmp_name"],'../../../public/static/upload');

        if($info) {
            $data = [
                'image' => config('live.host')."/upload/".$info->getSaveName(),
            ];
            echo Util::show(config('code.success'), 'OK', $data);
        }else {
            echo Util::show(config('code.error'), 'error');
        }
    }

}
