<?php

namespace db;


use MongoDB\BSON\ObjectId;
use MongoDB\Driver\Cursor;
use tiny\MongoDB;

class FriendRequest extends MongoDB {
  protected $table = "FriendRequest";

  const _id = "_id";
  const senderUid = "senderUid";
  const receiverUid = "receiverUid";
  const state = "state";
  const createAt = "createAt";

  const default_state = 0;
  const agree_state = 1;
  const refuse_state = 2;

  private $id;

  public function __construct(string $id = "") {
    $this->id = $id;
    return parent::__construct();
  }

  public function addOneRecord(string $senderUid, string $receiverUid): int {
    $res = $this->create([
      self::_id => new ObjectId() . "",
      self::senderUid => $senderUid,
      self::receiverUid => $receiverUid,
      self::state => self::default_state,
      self::createAt => millisecond()
    ]);
    if ($res) {
      return 1;
    }
    return 0;
  }

  public function getRecordByReceiverUid(string $receiverUid): Cursor {
    return $this->where(self::receiverUid, '=', $receiverUid)->field('_id')->find();

  }

  public function getInfoByIds(array $ids): Cursor {
    return $this->in(self::_id, $ids)->find();

  }

  public function setState(int $state): bool {
    $res = $this->where(self::state, '=', $state)->update();
    return $res;
  }
}