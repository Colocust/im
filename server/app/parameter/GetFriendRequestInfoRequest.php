<?php

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

  const id = "id";
}