<?php

namespace api;


class GetCaptchaRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $telephone;
}