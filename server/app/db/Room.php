<?php

namespace db;

use MongoDB\Driver\Cursor;
use tiny\Logger;
use tiny\MongoDB;

class Room extends MongoDB {
  protected $table = "Room";

  const members = "members";
  const id = "_id";
  const createTime = 'createTime';

  private $id;

  public function getId(): string {
    return $this->id;
  }

  public function buildByMembers(array $members): bool {
    $values = self::in(self::members, $members)->find()->toArray();
    if (count($values) == 0) {
      return false;
    }
    Logger::getInstance()->info(json_encode($members));
    foreach ($values as $key => $value) {
      if (empty(array_diff($members, $value->{self::members}))) {
        $id = $value->{self::id};
        $this->id = $id;
        return true;
      }
    }
    return false;
  }

  public function initByMembers(array $members): bool {
    $_id = md5($members[0] . $members[1]);
    self::create([
      self::id => $_id,
      self::members => $members,
      self::createTime => millisecond()
    ]);
    $this->id = $_id;
    return true;
  }

  public function findByMember(string $uid): Cursor {
    return $this->in(self::members, [$uid])->find();
  }

}