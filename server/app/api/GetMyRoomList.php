<?php


namespace api;


use db\Room;

class GetMyRoomList extends API {

  public function requestClass(): Request {
    return new GetMyRoomListRequest();
  }

  public function doRun(): Response {
    $request = GetMyRoomListRequest::fromAPI($this);
    $response = new GetMyRoomListResponse();

    $room = new Room();
    $res = $room->findByMember($this->getNet()->getUID());
    foreach ($res as $one) {
      $response->ids[] = $one->_id;
    }
    return $response;
  }
}