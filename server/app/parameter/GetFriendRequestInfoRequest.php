<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:23
 */

namespace api;


class GetFriendRequestInfoRequest extends Request {
  /**
   * @var string[]
   * @uses required
   */
  public $ids;
  /**
   * @var string[]
   * @uses required
   */
  public $fields;
}