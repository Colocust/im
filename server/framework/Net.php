<?php

namespace tiny;

use db\MyTokenInfo;

class Net {
  private $uid;
  private $channel;

  //获取用户id
  public function getUID() {
    return $this->uid;
  }

  //创建网络
  public function createNet(MyTokenInfo $info) {
    $this->uid = $info->uid;
  }

  public function getChannel() {
    return $this->channel;
  }
}