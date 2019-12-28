<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/30
 * Time: 16:34
 */

namespace tiny;

class Redis {
  /**
   * @var \Redis
   */
  protected $redis;

  //类的实例化
  private static $instance = null;

  function __destruct() {
    if ($this->redis == null) $this->redis->close();
  }

  private function __construct() {
    $this->redis = new \Redis();
    $res = $this->redis->connect(config('db.redis.host'),
      config('db.redis.port'),
      config('db.redis.timeout'));
    if (!$res) {
      throw new \Exception("connect redis error");
    }
    $this->redis->select(config('db.redis.db'));
  }

  public static function getInstance(): Redis {
    if (self::$instance === null) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  //获取redis对象
  public function redis() {
    return $this->redis;
  }
}