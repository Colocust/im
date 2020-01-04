<?php


namespace api;


class GetMyRoomInfoResponseItem {
  /**
   * @var string
   */
  public $id; // string  md5(uid +　createTime + rand(1,9))
  /**
   * @var string[]
   */
  public $members; // string[] 房间成员

  public function __construct(string $id = "") {
    $this->id = $id;
  }
}