<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 15:31
 */

namespace api;


class SetFriendRequestStateRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $id;
  /**
   * @var int
   * @uses required
   */
  public $state;
}