<?php

use db\Message;
use db\RedisType;
use db\Room;
use swoole\MessageType;
use tiny\Container;
use tiny\Loader;
use tiny\Logger;
use tiny\Redis;

require '../framework/Loader.php';

Loader::register();
Container::get("app")->initialize();


class WebSocketServer {

  public function __construct() {
    $ws = new swoole_websocket_server(config('swoole.websocket.host'), config('swoole.websocket.port'));

    $ws->on('open', [$this, 'onOpen']);
    $ws->on('message', [$this, 'onMessage']);
    $ws->on('task', [$this, 'onTask']);
    $ws->on('finish', [$this, 'onFinish']);
    $ws->on('close', [$this, 'onClose']);

    $ws->set([
      'worker_num' => 8,
      'task_worker_num' => 8,
    ]);
    $ws->start();
  }

  public function onOpen($ws, $request) {
    //设置实例
    $_POST['ws'] = $ws;

    $uid = json_decode($request->get['uid']);

    //uid绑定线程id
    Redis::getInstance()->redis()->sAdd(RedisType::WS . $uid, $request->fd);
    //线程id绑定uid
    Redis::getInstance()->redis()->set(RedisType::WS . $request->fd, $uid);

    Logger::getInstance()->info("uid{$uid}与fd{$request->fd}双向绑定成功");
  }

  //通过uid获取fd
  //判断
  public function onMessage($ws, $frame) {
    $receiveUid = $frame->data->receiveUid;
    $senderUid = $frame->data->senderUid;
    $message = $frame->data->message;

    //获取用户的所有线程id
    $fds = Redis::getInstance()->redis()->sMembers(RedisType::WS . $receiveUid);

    $taskData = [
      'senderUid' => $senderUid,
      'receiveUid' => $receiveUid,
      'message' => $message
    ];

    $ws->task($taskData);

    $data = [
      'message' => $message,
      'type' => MessageType::MESSAGE
    ];

    //推送
    foreach ($fds as $fd) {
      $ws->push($fd, json_encode($data));
    }
  }

  //销毁redis
  public function onClose($ws, $fd) {
    //获取fd对应的uid
    $uid = Redis::getInstance()->redis()->get(RedisType::WS . $fd);
    //删除fd对应的uid的记录
    Redis::getInstance()->redis()->del(RedisType::WS . $fd);
    //删除该uid的线程id
    Redis::getInstance()->redis()->sRem(RedisType::WS . $uid, $fd);

    Logger::getInstance()->info("{$fd}断开了连接");
  }

  public function onTask(swoole_server $server, int $taskId, int $workId, $data) {
    $senderUid = $data['senderUid'];
    $receiveUid = $data['receiveUid'];
    $sendMessage = $data['message'];

    $members = [
      $senderUid, $receiveUid
    ];

    //查找roomId
    $room = new Room();
    if (!$room->buildByMembers($members)) {
      $room->initByMembers($members);
    }
    $roomId = $room->getId();

    //插入message
    $message = new Message();
    $message->insert($roomId, $senderUid, $receiveUid, $sendMessage);
    return "finish";
  }

  public function onFinish(swoole_server $server, int $taskId, $data) {
    Logger::getInstance()->info('finish');
  }
}

$ws = new WebSocketServer();