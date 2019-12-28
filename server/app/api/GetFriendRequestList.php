<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:17
 */

namespace api;


use db\FriendRequest;

class GetFriendRequestList extends API {

  public function requestClass(): Request {
    return new GetFriendRequestListRequest();
  }

  public function doRun(): Response {
    $request = GetFriendRequestListRequest::fromAPI($this);
    $response = new GetFriendRequestListResponse();

    $friendRequest = new FriendRequest();
    $res = $friendRequest->getRecordByReceiverUid($this->getNet()->getUID());

    foreach ($res as $one) {
      $response->ids[] = $one->_id;
    }

    return $response;
  }
}