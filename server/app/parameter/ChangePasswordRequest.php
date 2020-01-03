<?php

namespace api;


class ChangePasswordRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $password;
  /**
   * @var string
   * @uses required
   */
  public $newPassword;
}