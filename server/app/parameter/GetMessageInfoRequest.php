<?php


namespace api;


class GetMessageInfoRequest extends Request {
  /**
   * @var string[]
   * @uses required
   */
  public $messageIds;
  /**
   * @var string[]
   * @uses required
   */
  public $fields;
}