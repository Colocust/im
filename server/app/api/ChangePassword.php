<?php

namespace api;


use db\AccountUser;
use service\Sms;
use tiny\Logger;

class ChangePassword extends API {

  public function requestClass(): Request {
    return new ChangePasswordRequest();
  }

  public function doRun(): Response {
    $request = ChangePasswordRequest::fromAPI($this);
    $response = new ChangePasswordResponse();


    $sms = new Sms();
    if (!$sms->check($request->telephone, $request->captcha)) {
      $response->result = 0;
      return $response;
    }

    $account = new AccountUser();
    if (!$account->buildByTelephone($request->telephone)) {
      Logger::getInstance()->warn("{$request->telephone}账号不存在");
      $response->result = 1;
      return $response;
    }

    $account->setPass(password_hash(md5($request->password), PASSWORD_DEFAULT));
    $response->result = 2;
    return $response;
  }

  protected function needToken(): bool {
    return false;
  }

}