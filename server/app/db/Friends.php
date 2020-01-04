<?php

namespace db;

use MongoDB\Driver\Cursor;
use tiny\MongoDB;

class Friends extends MongoDB {
  //好友列表
  protected $table = 'Friends';

  const _id = "_id"; //md5(senderUid . receiverUid)
  const senderUid = "senderUid";
  const receiverUid = "receiverUid";
  const createAt = "createAt";

  public function getBySenderUid(string $senderUid): Cursor {
    return $this->where(self::senderUid, '=', $senderUid)->find();

  }

  public function getByReceiverUid(string $receiverUid): Cursor {
    return $this->where(self::receiverUid, '=', $receiverUid)->find();
  }

  public function addOneRecord(string $receiverUid, string $senderUid) {
    $this->create([
      self::_id => md5($senderUid . $receiverUid),
      self::receiverUid => $receiverUid,
      self::senderUid => $senderUid,
      self::createAt => millisecond()
    ]);
  }
}