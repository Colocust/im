<?php

namespace db;

use tiny\Redis;

class MyToken {
  private $token;

  public function __construct($token = "") {
    $this->token = $token;
  }

  //设置token
  public function setToken(MyTokenInfo $info, int $ttl = 30 * 24 * 3600) {
    Redis::getInstance()->redis()->setex(RedisType::NET . $info->token, $ttl, json_encode($info));
  }

  //获取token信息 token过期时间延长一个月
  public function getToken(MyTokenInfo $info) {
    Redis::getInstance()->redis()->expire(RedisType::NET . $this->token, 30 * 24 * 3600);
    $res = Redis::getInstance()->redis()->get(RedisType::NET . $this->token);
    $object = json_decode($res);
    if (!$object) return false;
    foreach ($object as $k => $v) {
      $info->{$k} = $v;
    }
    return true;
  }

  //删除token
  public function delToken() {
    Redis::getInstance()->redis()->del(RedisType::NET . $this->token);
  }
}
