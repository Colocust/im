<?php


namespace api;


use db\Room;
use db\RoomInfo;

class GetMyRoomInfo extends API {

  public function requestClass(): Request {
    return new GetMyRoomInfoRequest();
  }

  public function doRun(): Response {
    $request = GetMyRoomInfoRequest::fromAPI($this);
    $response = new GetMyRoomInfoResponse();

    $room = new Room();
    $values = $room->findByIds($request->roomIds);
    /**
     * @var $value RoomInfo
     */
    foreach ($values as $value) {
      $item = new GetMyRoomInfoResponseItem($value->_id);
      foreach ($request->fields as $field) {
        if (!isset($value->{$field})) continue;
        $item->{$field} = $value->{$field};
      }
      $response->items[] = $item;
    }

    return $response;
  }
}