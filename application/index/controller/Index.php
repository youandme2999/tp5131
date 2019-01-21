<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use Swoole\Client;

class Index extends Controller
{
    //swoole之TCP客户端
    public function tcpClient(Request $request)
    {
        $id = $request->param('id',rand(1000,9999));

        $ip = '39.105.129.105';
        $port = '9510';
        $msg = $id.' send to msg';
        $client = new \swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);

        //连接到服务器
        if (!$client->connect($ip, $port, 5))
        {
            die("connect failed.");
        }
        //向服务器发送数据
        if (!$client->send($msg))
        {
            die("send failed.");
        }
        //从服务器接收数据
        $data = $client->recv();
        if (!$data)
        {
            die("recv failed.");
        }
        echo $data."\n";
        //关闭连接
//        $client->close();


        //自定义TCP
//        $response = socket_send_message('39.105.129.105',9510,$id.' send to msg');
//        var_dump($response);
    }

    //webSocket聊天室
    public function webSocketChat()
    {
        return $this->fetch();
    }

    //上传图片
    public function uploadImg()
    {
        if(request()->isPost()){

        }
        return $this->fetch();
    }

    public function index()
    {
//        $redis = new \Redis();
//        $redis -> connect('127.0.0.1',6379);
//        //获取聚合中所有的值
//        $list = $redis->sMembers('userList');
//        pre($list);
//        foreach ($list as $value) {
//            $redis->del(strstr($value,'_',true));
//        }
//        $redis->delete('userList');
//        $list = $redis->sMembers('userList');
//        pre($list);


        $objData = Db::name('user')->field('user_id,user_nickname')->paginate();
        return 'welcome to thinkphp5.1.31';
    }

    public function search(Request $request)
    {
        $search = $request->param('name','');
        $where = [];
        if(!empty($search)){
            $where[] = ['goods_name','like','%'.$search.'%'];
        }
        $data = Db::name('goods')->field('goods_id,goods_name')->where($where)->select();
        return 'showData('.json_encode($data,JSON_UNESCAPED_UNICODE).')';
    }
}
