<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:24
 */

namespace api;


class GetFriendRequestInfoResponseItem {
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
  public $senderUid;   //string
  /**
   * @var string
   */
  public $receiverUid; //string
  /**
   * @var int
   */
  public $state;       //int  0未处理 1同意 2失败
  /**
   * @var int
   */
  public $createAt;    //int
}