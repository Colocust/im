<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 18:08
 */

namespace api;


class ChangePasswordResponse extends Response {
  /**
   * @var int
   */
  public $result = 0;//0失败密码错误 1成功
}