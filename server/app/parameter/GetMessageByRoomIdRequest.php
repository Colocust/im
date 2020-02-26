<?php


namespace api;


class GetMessageByRoomIdRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $roomId;
}