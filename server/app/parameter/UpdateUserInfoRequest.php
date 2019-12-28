<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 17:53
 */

namespace api;


class UpdateUserInfoRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $avatar;
  /**
   * @var string
   * @uses required
   */
  public $nickName;
}