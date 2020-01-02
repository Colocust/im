<?php

use db\Message;
use db\Room;
use db\UserFd;
use tiny\Container;
use tiny\Loader;
use tiny\Logger;

require '../framework/Loader.php';

Loader::register();
Container::get("app")->initialize();


class WebSocket {

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
    $uid = json_decode($request->get['uid']);
    $userFd = new UserFd($uid);
    $userFd->setUserFd($request->fd);
    Logger::getInstance()->info('uid与fd绑定成功');
  }

  //通过uid获取fd
  //判断
  public function onMessage($ws, $frame) {
    $receiveUid = $frame->data->receiveUid;
    $senderUid = $frame->data->senderUid;
    $message = $frame->data->message;

    Logger::getInstance()->info('frame' . json_encode($frame));
    Logger::getInstance()->info('receive' . $frame->data);

    //获取用户的所有线程id
    $userFd = new UserFd($receiveUid);
    $fds = $userFd->getUserFds();

    $taskData = [
      'senderUid' => $senderUid,
      'receiveUid' => $receiveUid,
      'message' => $message
    ];

    $ws->task($taskData);

    //推送
    foreach ($fds as $fd) {
      $ws->push($fd, $message);
    }
  }


  //销毁redis
  public function onClose($ws, $fd) {
    $userFd = new UserFd();
    $uid = $userFd->getUID();
    Logger::getInstance()->info('uid' . $uid);
    Logger::getInstance()->info('ws' . json_encode($ws));
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

    return;
  }

  public function onFinish(swoole_server $server, int $taskId, $data) {
    Logger::getInstance()->info('finish');
  }
}

$ws = new WebSocket();