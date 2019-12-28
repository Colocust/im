<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:28
 */

namespace api;

use db\AccountUser;
use service\Sms;
use tiny\Redis;

class RegisterUser extends API {

  public function requestClass(): Request {
    return new RegisterUserRequest();
  }

  public function doRun(): Response {
    $request = RegisterUserRequest::fromAPI($this);
    $response = new RegisterUserResponse();

    $accountUser = new AccountUser();
    if ($accountUser->buildByTelephone($request->telephone)) {
      $response->result = 0;
      return $response;
    }

    $sms = new Sms();
    if (!$sms->check($request->telephone, $request->captcha)) {
      $response->result = 1;
      return $response;
    }

    if (!$accountUser->initByTelephone($request->telephone,$request->password)) {
      $response->result = 2;
    }

    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}