<?php

namespace api;


class AddUserFriendRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $receiverUid;
}