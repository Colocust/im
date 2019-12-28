<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:48
 */

namespace tiny;

class Container {

  private function __construct() {
    self::$instance = null;
  }

  private static $instance;

  //容器类的实例
  private $instances = [];

  //容器中提前绑定的类
  private $bind = [
    'app' => App::class,
    'config' => Config::class,
    'main' => Main::class,
    'validate' => Validate::class,
    'net' => Net::class
  ];

  //获取类的实例
  public static function getInstance(): Container {
    if (self::$instance === null) {
      self::$instance = new static();
    }
    return self::$instance;
  }

  //获取容器中类的实例
  public static function get($abstract): object {
    return self::getInstance()->make($abstract);
  }

  //在容器中创建类的实例
  public function make(string $abstract): object {
    //判断是否在类的实例数组中设置了该类
    if (isset($this->instances[$abstract])) {
      return $this->instances[$abstract];
    }

    if (isset($this->bind[$abstract])) {
      $class = $this->bind[$abstract];
      return $this->make($class);
    } else {
      $object = $this->invokeClass($abstract);
    }
    $this->instances[$abstract] = $object;
    return $object;
  }

  //返回这个类的实例
  public function invokeClass(string $class): object {
    $reflect = new \ReflectionClass($class);
    return $reflect->newInstanceArgs();
  }

  public function bound($abstract) {
    return isset($this->bind[$abstract]) || isset($this->instances[$abstract]);
  }
}