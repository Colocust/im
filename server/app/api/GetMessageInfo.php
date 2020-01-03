<?php


namespace api;


use db\Message;

class GetMessageInfo extends API {

  public function requestClass(): Request {
    return new GetMessageInfoRequest();
  }

  public function doRun(): Response {
    $request = GetMessageInfoRequest::fromAPI($this);
    $response = new GetMessageInfoResponse();

    $message = new Message();
    $res = $message->getByIds($request->messageIds);
    foreach ($res as $one) {
      $item = new GetMessageInfoResponseItem($one->_id);
      foreach ($request->fields as $field) {
        if (!isset($one->{$field})) continue;
        $item->{$field} = $one->{$field};
      }
      $response->items[] = $item;
    }
    return $response;
  }
}