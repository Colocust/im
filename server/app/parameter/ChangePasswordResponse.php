<?php

namespace api;


class ChangePasswordResponse extends Response {
  /**
   * @var int
   */
  public $result = 0;//0失败验证码错误 1账号不存在 2成功
}