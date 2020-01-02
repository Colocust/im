<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 18:07
 */

namespace api;


use db\AccountUser;
use tiny\Logger;

class ChangePassword extends API {

  public function requestClass(): Request {
    return new ChangePasswordRequest();
  }

  public function doRun(): Response {
    $request = ChangePasswordRequest::fromAPI($this);
    $response = new ChangePasswordResponse();
    $account = new AccountUser($this->getNet()->getUID());
    if (!$account->verify(md5($request->password))) {
      Logger::getInstance()->warn('密码错误');
      return $response;
    }

    $account->setPass(password_hash(md5($request->newPassword), PASSWORD_DEFAULT));
    $response->result = 1;
    return $response;
  }
}