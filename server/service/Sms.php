<?php

namespace service;

require "../extend/sms/api_demo/SmsDemo.php";

use tiny\Logger;
use tiny\Redis;

class Sms {
  public function send(string $telephone): bool {
    $captcha = rand(100000, 999999);
    $res = \SmsDemo::sendSms($telephone, $captcha);
    if ($res->Code == 'OK') {
      Redis::getInstance()->redis()->setex($telephone, 15 * 60, $captcha);
      return true;
    }
    return false;
  }

  public function check(string $telephone, int $captcha): bool {
    if (Redis::getInstance()->redis()->get($telephone) == $captcha) {
      Redis::getInstance()->redis()->del($telephone);
      return true;
    }
    Logger::getInstance()->error($telephone . " and " . $captcha . " is not matched");
    return false;
  }
}