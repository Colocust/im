<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 17:32
 */

namespace api;

use db\AccountUser;

class UpdateUserInfo extends API {

  public function requestClass(): Request {
    return new UpdateUserInfoRequest();
  }

  public function doRun(): Response {
    $request = UpdateUserInfoRequest::fromAPI($this);
    $response = new UpdateUserInfoResponse();

    $user = new AccountUser($this->getNet()->getUID());
    $user->updateAvatarAndNickname($request->avatar, $request->nickName);

    return $response;
  }
}