<?php

namespace db;


use MongoDB\BSON\ObjectId;
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

  public function insert(string $roomId, string $senderUid, string $receiveUid, string $content) {
    self::create([
      self::_id => new ObjectId() . "",
      self::senderUid => $senderUid,
      self::receiverUid => $receiveUid,
      self::room_id => $roomId,
      self::content => $content,
      self::state => self::NOT_READ,
      self::createAt => millisecond()
    ]);
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