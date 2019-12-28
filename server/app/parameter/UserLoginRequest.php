<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:02
 */

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