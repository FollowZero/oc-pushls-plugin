<?php
namespace Plus\Pushls;
use Hhxsv5\LaravelS\Swoole\WebSocketHandlerInterface;
use Plus\Pushls\Models\Settings;
use Swoole\Http\Request;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
/**
 * @see https://wiki.swoole.com/wiki/page/400.html
 */
class WebSocketService implements WebSocketHandlerInterface
{
    // 声明没有参数的构造函数
    public function __construct()
    {
    }
    public function onOpen(Server $server, Request $request)
    {
        // 在触发onOpen事件之前Laravel的生命周期已经完结，所以Laravel的Request是可读的，Session是可读写的
        // \Log::info('New WebSocket connection', [$request->fd, request()->all(), session()->getId(), session('xxx'), session(['yyy' => time()])]);
        // $server->push($request->fd, 'Welcome to LaravelS');
        // throw new \Exception('an exception');// 此时抛出的异常上层会忽略，并记录到Swoole日志，需要开发者try/catch捕获处理
        //判断是否传递了app_key参数
        if(!isset($request->get["app_key"])){
            $data = [
                "type" => "app_key empty"
            ];
            $server->push($request->fd, json_encode($data));
            return;
        }
        //判断是否传递了channel参数
        if(!isset($request->get["channel"])){
            $data = [
                "type" => "channel empty"
            ];
            $server->push($request->fd, json_encode($data));
            return;
        }
        $app_key_re = $request->get["app_key"];//获取app_key
        $settings = Settings::instance();
        $app_key_se=$settings->app_key;
        if($app_key_re!=$app_key_se){
            $data = [
                "type" => "app_key error"
            ];
            $server->push($request->fd, json_encode($data));
            return;
        }
        //绑定fd变更状态
        app('swoole')->wsTable->set('cid:' . $request->get["channel"], ["value"=>$request->fd]);// 绑定cid到fd的映射
        app('swoole')->wsTable->set('fd:' . $request->fd,["value"=>$request->get["channel"]]);// 绑定fd到cid的映射
        $data = [
            "type" => "Connection success",
            "data" => [
                "fd"  => $request->fd,
                "cid"    => $request->get["channel"],
            ]
        ];
        $server->push($request->fd, json_encode($data));
        return;
    }
    public function onMessage(Server $server, Frame $frame)
    {
        // \Log::info('Received message', [$frame->fd, $frame->data, $frame->opcode, $frame->finish]);
        $server->push($frame->fd, date('Y-m-d H:i:s'));
        // throw new \Exception('an exception');// 此时抛出的异常上层会忽略，并记录到Swoole日志，需要开发者try/catch捕获处理
    }
    public function onClose(Server $server, $fd, $reactorId)
    {
        // throw new \Exception('an exception');// 此时抛出的异常上层会忽略，并记录到Swoole日志，需要开发者try/catch捕获处理
    }
}