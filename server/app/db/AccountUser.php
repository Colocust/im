<?php

namespace db;

use MongoDB\BSON\ObjectId;
use tiny\MongoDB;

class AccountUser extends MongoDB {
  protected $table = 'AccountUser';

  const uid = "_id";
  const telephone = "telephone";
  const avatar = "avatar";
  const nickName = "nickname";
  const createAt = "createAt";
  const password = "password";


  const defaultName = "Tiny_IM";
  const defaultAvatar = "http://qim.colocust.cn/images/logo.png";

  private $uid;

  public function __construct(string $uid = "") {
    $this->uid = $uid;
    return parent::__construct();
  }


  public function get() {
    return $this->find()->toArray();
  }

  public function buildByTelephone(string $telephone): bool {
    $values = $this->where(self::telephone, '=', $telephone)->find()->toArray();
    if (count($values) == 0) {
      return false;
    }
    $this->uid = $values[0]->{self::uid};
    return true;
  }

  public function getInfo(AccountUserInfo $info): int {
    $values = $this->where(self::uid, '=', $this->uid)->find()->toArray();
    if (count($values) == 0) {
      return 0;
    }
    foreach ($values[0] as $key => $value) {
      $info->{$key} = $value;
    }
    return 1;
  }

  public function initByTelephone(string $telephone, string $password): bool {
    $value = $this->create([
      self::uid => new ObjectId() . "",
      self::telephone => $telephone,
      self::password => password_hash(md5($password), PASSWORD_DEFAULT),
      self::createAt => millisecond(),
      self::nickName => self::defaultName . time() . rand(0, 9),
      self::avatar => self::defaultAvatar
    ]);
    return $value;
  }

  public function getUID(): string {
    return $this->uid;
  }
}