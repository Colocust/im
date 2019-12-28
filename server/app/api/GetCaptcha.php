<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 18:14
 */

namespace api;

use db\AccountUser;
use service\Sms;

class GetCaptcha extends API {

  public function requestClass(): Request {
    return new GetCaptchaRequest();
  }

  public function doRun(): Response {
    $request = GetCaptchaRequest::fromAPI($this);
    $response = new GetCaptchaResponse();

    $user = new AccountUser();
    if ($user->buildByTelephone($request->telephone)) {
      $response->result = 1;
      return $response;
    }

    $sms = new Sms();

    if ($sms->send($request->telephone)) {
      $response->result = 2;
    }

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}