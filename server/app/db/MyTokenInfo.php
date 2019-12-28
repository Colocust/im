<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/5
 * Time: 14:43
 */

namespace db;


class MyTokenInfo {
  public $uid;
  public $token;

  static public function newToken(string $uid): MyTokenInfo {
    $info = new MyTokenInfo();
    $info->uid = $uid;
    $info->token = md5(millisecond() . mt_rand(10, 10000) . $uid . mt_rand(10000, 20000));
    return $info;
  }
}
