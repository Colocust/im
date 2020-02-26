<?php


namespace api;


use db\Message;

class GetMessageByRoomId extends API {

  public function requestClass(): Request {
    return new GetMessageByRoomIdRequest();
  }

  public function doRun(): Response {
    $request = GetMessageByRoomIdRequest::fromAPI($this);
    $response = new GetMessageByRoomIdResponse();

    $message = new Message();
    $res = $message->getByRoomId($request->roomId);
    foreach ($res as $one) {
      $item = new GetMessageByRoomIdResponseItem();
      $item->id = $one->_id;
      $item->room_id = $request->roomId;
      $item->senderUid = $one->senderUid;
      $item->receiveUid = $one->receiveUid;
      $item->content = $one->content;
      $item->state = $one->state;
      $item->createAt = date('m-d H:i', $one->createAt / 1000);

      $item->float = $one->senderUid == $this->getNet()->getUID() ? 1 : 0;

      $response->items[] = $item;
    }

    return $response;
  }
}