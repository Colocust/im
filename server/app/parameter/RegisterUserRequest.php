<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:28
 */

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