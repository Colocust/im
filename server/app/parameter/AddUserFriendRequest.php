<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:09
 */

namespace api;


class AddUserFriendRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $receiverUid;
}