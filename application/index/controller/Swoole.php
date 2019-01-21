<?php
namespace app\http;

use think\swoole\Server;

class Swoole extends Server
{
    protected $host = '0.0.0.0';
    protected $port = 9508;
    protected $serverType = 'socket';
    protected $mode = SWOOLE_PROCESS;
    protected $sockType = SWOOLE_SOCK_TCP;
    protected $option = [
        'worker_num'=> 4,
        'daemonize'	=> flase,
        'backlog'	=> 128
    ];

    public function onReceive($server, $fd, $from_id, $data)
    {
        echo $fd.' to '.$data."\n";
        $server->send($fd, 'Swoole: '.$data);
    }
}
