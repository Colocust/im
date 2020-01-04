<?php

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