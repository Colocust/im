<?php

namespace api;


class GetUserInfoResponseItem {
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
  public $telephone;
  /**
   * @var string
   */
  public $avatar;
  /**
   * @var string
   */
  public $nickname;
  /**
   * @var int
   */
  public $createAt;
  /**
   * @var string
   */
  public $password;
}