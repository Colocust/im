<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:16
 */

namespace db;

use tiny\MongoDB;

class Friends extends MongoDB {
  //好友列表
  protected $table = 'Friends';

  const _id = "_id"; //md5(senderUid . receiverUid)
  const senderUid = "senderUid";
  const receiverUid = "receiverUid";
  const createAt = "createAt";

  public function getBySenderUid(string $senderUid): array {
    $res = $this->where(self::senderUid, '=', $senderUid)->find();
    return $res;
  }

  public function getByReceiverUid(string $receiverUid): array {
    $res = $this->where(self::receiverUid, '=', $receiverUid)->find();
    return $res;
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