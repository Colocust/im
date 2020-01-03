<?php

namespace api;

class RegisterUserRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $telephone;
  /**
   * @var int
   * @uses required
   */
  public $captcha;
  /**
   * @var string
   * @uses required
   */
  public $password;
}