<?php


namespace api;

use db\Message;

class GetMessageList extends API {

  public function requestClass(): Request {
    return new GetMessageListRequest();
  }

  public function doRun(): Response {
    $request = GetMessageListRequest::fromAPI($this);
    $response = new GetMessageListResponse();

    $message = new Message();
    $res = $message->getByRoomId($request->roomId);
    foreach ($res as $one) {
      $response->messageIds[] = $one->_id;
    }
    return $response;
  }
}