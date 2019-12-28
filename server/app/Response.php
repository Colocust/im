<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:47
 */

namespace api;

use tiny\Code;

class Response {
  /**
   * @var int
   * @uses required
   */
  public $code;

  public function __construct(int $code = Code::SUCCESS) {
    $this->code = $code;
  }
}