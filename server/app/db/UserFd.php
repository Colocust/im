<?php

namespace db;

use tiny\Redis;

//使用redis的集合存储fd
class UserFd {

  private $uid;

  public function __construct(string $uid = "") {
    $this->uid = 'fd_' . $uid;
  }

  //设置用户的线程id
  public function setUserFd(string $fd): bool {
    Redis::getInstance()->redis()->sAdd($this->uid, $fd);
    return true;
  }

  //获取用户的线程ids
  public function getUserFds() {
    return Redis::getInstance()->redis()->sMembers($this->uid);
  }

  //移除用户的线程id
  public function removeUserFd(string $fd): bool {
    Redis::getInstance()->redis()->lRem($this->uid, $fd, 0);
    return true;
  }

  public function getUID() {
    return $this->uid;
  }
}