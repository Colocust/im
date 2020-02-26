<?php


namespace swoole;

use db\Message;
use db\RedisType;
use db\Room;
use tiny\Redis;

class Task {

  //发送消息
  public function sendMessage($ws, $data) {
    $messageId = $data->id;
    $senderUid = $data->senderUid;
    $receiveUid = $data->receiveUid;
    $createAt = $data->createAt;
    $message = $data->message;

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
    $messageDB->insert($messageId, $roomId, $senderUid, $receiveUid, $message, $createAt);

    $data->roomId = $roomId;
    //获取用户的所有线程id
    $fds = Redis::getInstance()->redis()->sMembers(RedisType::WS . $receiveUid);
    foreach ($fds as $fd) {
      $ws->push($fd, json_encode($data));
    }
  }
}