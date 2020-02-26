<?php


namespace api;


use db\Room;

class GetRoomByMembers extends API {

  public function requestClass(): Request {
    return new GetRoomByMembersRequest();
  }

  public function doRun(): Response {
    $request = GetRoomByMembersRequest::fromAPI($this);
    $response = new GetRoomByMembersResponse();

    $members = [$request->memberId, $this->getNet()->getUID()];
    $room = new Room();
    if (!$room->buildByMembers($members)) {
      $room->initByMembers($members);
    }

    $response->roomId = $room->getId();
    return $response;
  }
}