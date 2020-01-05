<?php

namespace api;


class GetCaptchaResponse extends Response {
  /**
   * @var int
   */
  public $result = 0; //0发送失败2发送成功
}