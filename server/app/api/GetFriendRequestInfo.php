<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 19:23
 */

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
      $item = new GetFriendRequestInfoResponseItem();
      foreach ($request->fields as $field) {
        if ($field == GetFriendRequestInfoRequest::id) {
          $item->{$field} = $one->_id;
          continue;
        }
        if (!isset($one->{$field})) continue;
        $item->{$field} = $one->{$field};
      }
      $response->items[] = $item;
    }
    return $response;
  }
}