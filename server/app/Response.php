<?php

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