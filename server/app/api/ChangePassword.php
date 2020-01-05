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
    $account = new AccountUser($this->getNet()->getUID());

    $sms = new Sms();
    if (!$sms->check($request->telephone, $request->captcha)) {
      $response->result = 0;
      return $response;
    }

    $account->setPass(password_hash(md5($request->password), PASSWORD_DEFAULT));
    $response->result = 1;
    return $response;
  }
}