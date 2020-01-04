<?php

namespace service\payment;

/**
 * Class Factory
 * @package service\wechat
 * @method static WeChatPay weChatPay()
 * @method static ALiPay aLiPay()
 */
class Factory {

  private static function make($name, $arguments) {
    $namespace = ucfirst($name);
    $app = "\\service\\payment\\{$namespace}";
    return new $app;
  }

  public static function __callStatic($name, $arguments) {
    return self::make($name, $arguments);
  }
}