<?php

namespace api;


class RegisterUserResponse extends Response {
  /**
   * @var int
   */
  public $result = 3; //0已注册 1验证码错误 2新增记录失败 3成功
}