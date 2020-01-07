<?php


namespace api;


use db\Message;

class ReadMessage extends API {

  public function requestClass(): Request {
    return new ReadMessageRequest();
  }

  public function doRun(): Response {
    $request = ReadMessageRequest::fromAPI($this);
    $response = new ReadMessageResponse();

    foreach ($request->messageIds as $messageId) {
      $message = new Message();
      $message->readMessage($messageId);
    }
    return $response;
  }
}