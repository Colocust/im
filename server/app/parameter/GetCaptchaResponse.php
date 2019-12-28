<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 18:14
 */

namespace api;


class GetCaptchaResponse extends Response {
  /**
   * @var int
   */
  public $result = 0; //0发送失败1已注册2发送成功
}