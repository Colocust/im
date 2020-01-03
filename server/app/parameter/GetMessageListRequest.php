<?php


namespace api;


class GetMessageListRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $roomId;
}