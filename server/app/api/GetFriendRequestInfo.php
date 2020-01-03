<?php

namespace api;


use db\FriendRequest;

class GetFriendRequestInfo extends API {

  public function requestClass(): Request {
    return new GetFriendRequestInfoRequest();
  }

  public function doRun(): Response {
    $request = GetFriendRequestInfoRequest::fromAPI($this);
    $response = new GetFriendRequestInfoResponse();

    $friendRequest = new FriendRequest();
    $res = $friendRequest->getInfoByIds($request->ids);
    foreach ($res as $one) {
      $item = new GetFriendRequestInfoResponseItem($one->_id);
      foreach ($request->fields as $field) {
        if (!isset($one->{$field})) continue;
        $item->{$field} = $one->{$field};
      }
      $response->items[] = $item;
    }
    return $response;
  }
}