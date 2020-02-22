<?php


namespace api;


class GetMyRoomResponseItem {
  /**
   * @var string
   */
  public $roomId;
  /**
   * @var string
   */
  public $memberId;
  /**
   * @var string
   */
  public $memberNickname;
  /**
   * @var string
   */
  public $memberAvatar;
  /**
   * @var string
   */
  public $lastMessage;
  /**
   * @var int
   */
  public $lastSendTime;
  /**
   * @var int
   */
  public $notReadNum;
}