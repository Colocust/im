<?php

namespace api;


use db\Friends;

class GetMyFriendList extends API {

  public function requestClass(): Request {
    return new GetMyFriendListRequest();
  }

  public function doRun(): Response {
    $request = GetMyFriendListRequest::fromAPI($this);
    $response = new GetMyFriendListResponse();

    $friends = new Friends();

    $res1 = $friends->getByReceiverUid($this->getNet()->getUID());
    $res2 = $friends->getBySenderUid($this->getNet()->getUID());

    foreach ($res1 as $one1) {
      $response->userIds[] = $one1->senderUid;
    }
    foreach ($res2 as $one2) {
      $response->userIds[] = $one2->receiverUid;
    }
    return $response;
  }
}