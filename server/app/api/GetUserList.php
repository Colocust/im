<?php


namespace api;


use db\AccountUser;

class GetUserList extends API {

  public function requestClass(): Request {
    return new GetUserListRequest();
  }

  public function doRun(): Response {
    $request = GetUserListRequest::fromAPI($this);
    $response = new GetUserListResponse();

    $user = new AccountUser();
    $res = $user->get();
    foreach ($res as $one) {
      $response->ids[] = $one->_id;
    }

    return $response;
  }
}