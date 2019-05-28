# oc-pushls-plugin
push by laravels

### 安装
```
   composer require "hhxsv5/laravel-s:~3.5.0" -vvv
```
### 注册
```php
'providers' => array_merge(include(base_path('modules/system/providers.php')), [

        // 'Illuminate\Html\HtmlServiceProvider', // Example

        'System\ServiceProvider',
//      'Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider',//我试的这个和下边的写法都行
         Hhxsv5\LaravelS\Illuminate\LaravelSServiceProvider::class,
    ]),
```
### 发布
```
    php artisan laravels publish
```
### 配置
```php
<?php
return [
    'listen_ip'                => env('LARAVELS_LISTEN_IP', '0.0.0.0'),
    'listen_port'              => env('LARAVELS_LISTEN_PORT', 20106),
    .
    .
    .
    'websocket'                => [
        'enable' => true,
        'handler' => \Plus\Pushls\WebSocketService::class,
    ],
    .
    .
    .
    'swoole_tables'  => [
        // 场景：WebSocket中cId与FD绑定
        'ws' => [// Key为Table名称，使用时会自动添加Table后缀，避免重名。这里定义名为wsTable的Table
            'size'   => 102400,//Table的最大行数
            'column' => [// Table的列定义
                ['name' => 'value', 'type' => \swoole_table::TYPE_INT, 'size' => 8],
            ],
        ],
    ],
    .
    .
    .
];

```
### 运行
```
   php bin/laravels {start|stop|restart|reload|info|help}
```
### 客户端
```php
    <script>
        //建立连接
        var ws = new WebSocket("ws://域名:端口?app_key=asdfghjkl852456&channel=789");
        ws.onopen = function (e) {
            console.log('Connection to server opened');
        }
        //收到消息处理
        ws.onmessage = function (e) {
            console.log(e);
        }
        ws.onclose = function (e) {
            console.log("Connection closed");
        }
    </script>
```
### 服务端
#### URL
```
    http(s)://域名:端口/pushls
```
#### Method
```
 Post
```
#### 参数
|  名称   |   描述  |
| --- | --- |
|  app_key   |    配置的app_key |
|  channel   |    接收人的表识 |
|  content   |    内容 |

### 感谢
laravels的QQ②群的群主