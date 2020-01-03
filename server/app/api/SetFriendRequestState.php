<?php

namespace api;

use db\FriendRequest;
use db\Friends;

class SetFriendRequestState extends API {

  public function requestClass(): Request {
    return new SetFriendRequestStateRequest();
  }

  public function doRun(): Response {
    $request = SetFriendRequestStateRequest::fromAPI($this);
    $response = new SetFriendRequestStateResponse();

    $friendRequest = new FriendRequest($request->id);
    $res = $friendRequest->getInfoByIds([$request->id]);
    if ($res[0]->{FriendRequest::receiverUid} != $this->getNet()->getUID()) {
      $response->result = 0;
    }
    $friendRequest->setState($request->state);

    //同意请求后添加好友列表
    if ($response->result == 1 && $request->state == FriendRequest::agree_state) {
      $friends = new Friends();
      $friends->addOneRecord($this->getNet()->getUID(), $res[0]->{FriendRequest::senderUid});
    }

    return $response;
  }
}