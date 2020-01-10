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


  public function updateAvatarAndNickname(string $avatar, string $nickname) {
    $this->where(self::uid, '=', $this->uid)->set(self::avatar, $avatar)->set(self::nickName, $nickname)->update();
  }

  public function verify(string $password): int {
    $results = $this->where(self::uid, '=', $this->getUID())->find()->toArray();
    $res1 = count($results);
    $res1 = $res1 && isset($results[0]->{self::password});
    $res1 = $res1 && password_verify($password, $results[0]->{self::password});
    return $res1;
  }

  public function setPass(string $password) {
    $this->where(self::uid, '=', $this->getUID())->set(self::password, $password)->update();
  }

  public function getUID(): string {
    return $this->uid;
  }
}