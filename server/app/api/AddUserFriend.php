<?php

namespace api;

use db\FriendRequest;

class AddUserFriend extends API {

  public function requestClass(): Request {
    return new AddUserFriendRequest();
  }

  public function doRun(): Response {
    $request = AddUserFriendRequest::fromAPI($this);
    $response = new AddUserFriendResponse();

    $friendRequest = new FriendRequest();
    $response->result = $friendRequest->addOneRecord($this->getNet()->getUID(), $request->receiverUid);

    return $response;
  }
}