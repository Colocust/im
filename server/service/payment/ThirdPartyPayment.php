<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/10/17
 * Time: 17:31
 */

namespace service\payment;


interface ThirdPartyPayment {
  public function pay(array $params);
}