<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:20
 */

namespace db;


use tiny\Logger;
use tiny\MongoDB;

class Room extends MongoDB {
  protected $table = "Room";

  const members = "members";
  const id = "_id";

  private $id;

  public function getId(): string {
    return $this->id;
  }

  public function buildByMembers(array $members): bool {
    $value = self::in(self::members, $members)->find();
    if (count($value) == 0) {
      return false;
    }
    $id = $value[0]->{self::id};
    $this->id = $id;
    return true;
  }

  public function initByMembers(array $members): bool {
    $_id = md5($members[0] . $members[1]);
    Logger::getInstance()->info('roomId' . $_id);
    self::create([
      self::id => $_id,
      self::members => $members
    ]);
    $this->id = $_id;
    return true;
  }
}