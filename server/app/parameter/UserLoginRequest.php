<?php

namespace api;


class UserLoginRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $telephone;
  /**
   * @var string
   * @uses required
   */
  public $password;
}