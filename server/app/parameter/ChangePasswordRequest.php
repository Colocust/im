<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 18:08
 */

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