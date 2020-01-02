<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 12:24
 */

namespace api;

use db\AccountUser;
use db\AccountUserInfo;

class GetUserInfo extends API {

  public function requestClass(): Request {
    return new GetUserInfoRequest();
  }

  public function doRun(): Response {
    $request = GetUserInfoRequest::fromAPI($this);
    $response = new GetUserInfoResponse();

    foreach ($request->ids as $id) {
      $accountUser = new AccountUser($id);
      $userInfo = new AccountUserInfo();
      if (!$accountUser->getInfo($userInfo)) continue;

      $item = new GetUserInfoResponseItem($userInfo->_id);
      foreach ($request->fields as $field) {

        if (!isset($userInfo->{$field})) continue;

        $item->{$field} = $userInfo->{$field};
      }
      $response->items[] = $item;
    }
    return $response;
  }
}