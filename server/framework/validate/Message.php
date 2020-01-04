<?php

namespace tiny\validate;

final class Message {

  //示例:{key} expect {rule} ,actual get {type} {value}
  private static $message = '%s except %s ,actual get %s %s';

  //获取验证的错误信息
  public static function getErrorMsg($rule, $key, $value): string {
    return sprintf(self::$message, $key, $rule, gettype($value), json_encode($value));
  }
}