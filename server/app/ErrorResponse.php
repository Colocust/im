<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/24
 * Time: 16:14
 */

namespace api;

use Tiny\Code;

final class ErrorResponse extends Response {

  public $errMsg;

  public function __construct(int $code = Code::ELSE_ERROR, string $errMsg = "运行错误") {
    parent::__construct($code);
    $this->errMsg = $errMsg;
  }
}