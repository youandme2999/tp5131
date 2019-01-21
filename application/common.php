<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
/**
 * 格式化打印
 */
function pre($data){
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}

//创建24位不重复订单号
function create_order_num() {
    $ordernum = time().substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8).str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
    return $ordernum;
}

function tcp_send($ip='39.107.85.52',$port='2346',$message)
{
    error_reporting(E_ALL);
    set_time_limit(0);
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket < 0) {
        return "socket_create() failed: reason: " . socket_strerror($socket) . "\n";
    }else {
        echo "创建OK.\n<br>";
    }
    $result = socket_connect($socket, $ip, $port);
    if ($result < 0) {
        return "socket_connect() failed.\nReason: ($result) " . socket_strerror($result) . "\n";
    }else {
        echo "连接OK\n<br>";
    }
    if(!socket_write($socket, $message, strlen($message))) {
        return "socket_write() failed: reason: " . socket_strerror($socket) . "\n";
    }else {
        echo "发送OK，内容为:<font color='red'>$message</font> <br>";
    }

//     while($out = socket_read($socket, 12800)) {
//        var_dump(json_decode($out,true));
//     }
    $out = socket_read($socket, 12800);
//    var_dump(json_decode($out,true));
    socket_close($socket);
    var_dump($out);
    $out = json_decode($out,true);
    if($out){
        return $out;
    }else{
        return false;
    }
}

/**
 * $ipserver IP地址
 * $portserver 端口号
 * $message 发送的内容
 *
 */
function socket_send_message($ipserver,$portserver,$message)
{
    $fp=stream_socket_client("tcp://$ipserver:$portserver", $errno, $errstr);

    if(!$fp)
    {
        echo "erreur : $errno - $errstr<br />";
        return false;//发送失败
    }else{
        fwrite($fp,$message);
        $response =  fread($fp, 12800);
//        file_put_contents('swooleClient.txt',$response."\r\n",FILE_APPEND);
//        var_dump($fp);
//        var_dump($message);
//        $response = json_decode($response,true);
//         var_dump($response);
        // if($response['status'] != 1)
        // {
        //   echo 'the command couldnt be executed...ncause <br>';
        // }else{
        //   echo 'execution successfull...<br>';
        // }
//        fclose($fp);
        return $response;
    }
}
