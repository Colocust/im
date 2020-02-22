<?php


namespace api;


class GetMessageInfoResponseItem {
  public function __construct(string $id = "") {
    $this->id = $id;
  }

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
   * @var int
   */
  public $createAt;
}