<?php

namespace api;


class GetCaptchaResponse extends Response {
  /**
   * @var int
   */
  public $result = 0; //0发送失败1已注册2发送成功
}