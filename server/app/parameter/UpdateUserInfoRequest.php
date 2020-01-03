<?php

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