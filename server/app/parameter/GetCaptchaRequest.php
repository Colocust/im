<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 18:14
 */

namespace api;


class GetCaptchaRequest extends Request {
  /**
   * @var string
   * @uses required
   */
  public $telephone;
}