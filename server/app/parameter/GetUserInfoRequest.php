<?php

namespace api;


class GetUserInfoRequest extends Request {
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