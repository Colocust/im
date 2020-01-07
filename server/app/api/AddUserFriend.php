<?php

namespace api;

use db\FriendRequest;
use swoole\MessageType;

class AddUserFriend extends API {

  public function requestClass(): Request {
    return new AddUserFriendRequest();
  }

  public function doRun(): Response {
    $request = AddUserFriendRequest::fromAPI($this);
    $response = new AddUserFriendResponse();

    $friendRequest = new FriendRequest();
    $response->result = $friendRequest->addOneRecord($this->getNet()->getUID(), $request->receiverUid);

    if ($response->result) {
      $num = count($friendRequest->getDefaultRecordByReceiverUid($request->receiverUid)->toArray());
      $data = [
        'type' => 'remind',
        'data' => [
          'receiveUid' => $request->receiverUid,
          'message' => [
            'type' => MessageType::REMIND,
            'content' => $num
          ]
        ]
      ];
      $_POST['ws']->task($data);
    }

    return $response;
  }
}