<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:26
 */

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

  public function insert(string $roomId, string $senderUid, string $receiveUid, string $content) {
    self::create([
      self::_id => new ObjectId() . "",
      self::senderUid => $senderUid,
      self::receiverUid => $receiveUid,
      self::room_id => $roomId,
      self::content => $content,
      self::createAt => millisecond()
    ]);
  }

  public function getByRoomId(string $roomId): Cursor {
    return $this->where(self::room_id, '=', $roomId)->find();
  }

  public function getByIds(array $ids): Cursor {
    return $this->in(self::_id, $ids)->find();
  }

}