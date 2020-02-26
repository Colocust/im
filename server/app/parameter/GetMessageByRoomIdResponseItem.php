<?php


namespace api;


class GetMessageByRoomIdResponseItem {
  /**
   * @var string
   */
  public $id;
  /**
   * @var string
   */
  public $room_id;
  /**
   * @var string
   */
  public $senderUid;
  /**
   * @var string
   */
  public $receiveUid;
  /**
   * @var string
   */
  public $content;
  /**
   * @var string
   */
  public $createAt;
  /**
   * @var int
   */
  public $float;
  /**
   * @var int
   */
  public $state;
}