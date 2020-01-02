<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 12:25
 */

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