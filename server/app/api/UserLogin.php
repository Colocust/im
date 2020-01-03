<?php

namespace api;


use db\AccountUser;
use db\AccountUserInfo;
use db\MyToken;
use db\MyTokenInfo;

class UserLogin extends API {

  public function requestClass(): Request {
    return new UserLoginRequest();
  }

  public function doRun(): Response {
    $request = UserLoginRequest::fromAPI($this);
    $response = new UserLoginResponse();

    $accountUser = new AccountUser();
    if (!$accountUser->buildByTelephone($request->telephone)) {
      $response->result = 0;
      return $response;
    }

    $userInfo = new AccountUserInfo();
    $accountUser->getInfo($userInfo);

    if (!password_verify(md5($request->password), $userInfo->password)) {
      $response->result = 1;
      return $response;
    }

    $myTokenInfo = MyTokenInfo::newToken($accountUser->getUID());
    $myToken = new MyToken();
    $myToken->setToken($myTokenInfo);

    $response->token = $myTokenInfo->token;
    return $response;
  }

  protected function needToken(): bool {
    return false;
  }
}