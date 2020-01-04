<?php


namespace api;


class GetMyRoomInfoRequest extends Request {
  /**
   * @var string[]
   * @uses required
   */
  public $roomIds;
  /**
   * @var string[]
   * @uses required
   */
  public $fields;
}