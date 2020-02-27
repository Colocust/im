<?php

namespace db;


use MongoDB\Driver\Cursor;
use tiny\MongoDB;

class Message extends MongoDB {
  protected $table = "Message";

  const _id = "_id";
  const room_id = "room_id";     //string
  const senderUid = "senderUid";   //string
  const receiverUid = "receiveUid"; //string
  const content = "content";     //string
  const createAt = "createAt";    //int
  const state = "state";

  const NOT_READ = 0;
  const HAS_READ = 1;

  public function insert(string $_id, string $roomId, string $senderUid, string $receiveUid, string $content, int $createAt) {
    self::create([
      self::_id => $_id,
      self::senderUid => $senderUid,
      self::receiverUid => $receiveUid,
      self::room_id => $roomId,
      self::content => $content,
      self::state => self::NOT_READ,
      self::createAt => $createAt
    ]);
  }

  public function getLastMessage(string $roomId) {
    $messages = $this->where(self::room_id, '=', $roomId)->sort(self::createAt, -1)->limit(1)->find()->toArray();
    if (!$messages) return false;
    return $messages[0];
  }

  public function getNotReadMessage(string $roomId): Cursor {
    return $this->where(self::room_id, '=', $roomId)
      ->where(self::state, '=', 0)->find();
  }

  public function getByRoomId(string $roomId): Cursor {
    return $this->where(self::room_id, '=', $roomId)->find();
  }

  public function getByIds(array $ids): Cursor {
    return $this->in(self::_id, $ids)->find();
  }

  public function readMessage(string $messageId) {
    $this->where(self::_id, '=', $messageId)->set(self::state, self::HAS_READ)->update();
  }
}