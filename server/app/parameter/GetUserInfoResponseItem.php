<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 12:25
 */

namespace api;


class GetUserInfoResponseItem {
  public function __construct($id) {
    $this->id = $id;
  }

  /**
   * @var string
   */
  public $id;

}