<?php

namespace service\payment;


interface ThirdPartyPayment {
  public function pay(array $params);
}