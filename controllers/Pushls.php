<?php namespace Plus\Pushls\Controllers;



use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Http\Request;
use Plus\Pushls\Models\Settings;

class Pushls extends Controller
{
    public $implement = [    ];
    
    public function __construct()
    {
        parent::__construct();
    }

    public function serve(Request $request){
        $redata['status']=200;
        $redata['msg']='操作成功';
        $app_key_re=$request->app_key;
        $settings = Settings::instance();
        $app_key_se=$settings->app_key;
        if($app_key_re!=$app_key_se){
            $redata['status']=-1;
            $redata['msg']='应用密钥错误';
            return $redata;
        }
        $channel=$request->channel;
        if(empty($channel)){
            $redata['status']=-2;
            $redata['msg']='频道为空';
            return $redata;
        }
        $content=$request->content;
        if(empty($content)){
            $redata['status']=-3;
            $redata['msg']='内容为空';
            return $redata;
        }
        $data = [
            "type" => "success",
            "data" => [
                "content"  => $content,
            ]
        ];
        $fd_arr = app('swoole')->wsTable->get('cid:' . $channel);
        app('swoole')->push($fd_arr['value'],json_encode($data));
        return $redata;
    }

}

        
        
        
        
        
        
        
        
        
        

        