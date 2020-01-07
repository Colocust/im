<?php


namespace swoole;

use db\Message;
use db\RedisType;
use db\Room;
use tiny\Redis;

class Task {
  //推送
  public function push($ws, array $data) {

  }

  //发送消息
  public function sendMessage($ws, array $data) {
    $senderUid = $data['senderUid'];
    $receiveUid = $data['receiveUid'];
    $message = $data['message'];

    //获取用户的所有线程id
    $fds = Redis::getInstance()->redis()->sMembers(RedisType::WS . $receiveUid);
    foreach ($fds as $fd) {
      $ws->push($fd, json_encode($message));
    }

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
    $messageDB = new Message();
    $messageDB->insert($roomId, $senderUid, $receiveUid, $message['content']);
  }

  //提示 例如好友
  public function remind($ws, array $data) {
    $receiveUid = $data['receiveUid'];
    $message = $data['message'];

    //获取用户的所有线程id
    $fds = Redis::getInstance()->redis()->sMembers(RedisType::WS . $receiveUid);
    foreach ($fds as $fd) {
      $ws->push($fd, json_encode($message));
    }
  }
}