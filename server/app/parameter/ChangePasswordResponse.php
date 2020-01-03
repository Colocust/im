<?php

namespace api;


class ChangePasswordResponse extends Response {
  /**
   * @var int
   */
  public $result = 0;//0失败密码错误 1成功
}