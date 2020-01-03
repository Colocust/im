<?php

namespace db;


class RoomInfo {
  public $_id; // string  md5(uid +　createTime + rand(1,9))
  public $members; // string[] 房间成员
}