<?php


namespace api;


use db\AccountUser;
use db\AccountUserInfo;
use db\Message;
use db\Room;

class GetMyRoom extends API {

  public function requestClass(): Request {
    return new GetMyRoomRequest();
  }

  public function doRun(): Response {
    $request = GetMyRoomRequest::fromAPI($this);
    $response = new GetMyRoomResponse();

    $room = new Room();
    $res = $room->findByMember($this->getNet()->getUID());
    foreach ($res as $one) {
      $item = new GetMyRoomResponseItem();
      $item->roomId = $one->_id;

      $memberInfo = $this->getMemberInfo($one->members);
      $item->memberId = $memberInfo->memberId;
      $item->memberAvatar = $memberInfo->memeberAvatar;
      $item->memberNickname = $memberInfo->nickname;

      $response->items[] = $item;
    }

    return $response;
  }

  private function getMemberInfo(array $members): \stdClass {
    $memberInfo = new \stdClass();
    foreach ($members as $member) {
      if ($member == $this->getNet()->getUID()) {
        continue;
      }
      $user = new AccountUser($member);
      $userInfo = new AccountUserInfo();
      $user->getInfo($userInfo);
      $memberInfo->avatar = $userInfo->avatar;
      $memberInfo->nickname = $userInfo->nickName;
      $memberInfo->memberId = $userInfo->_id;
      return $memberInfo;
    }
    return $memberInfo;
  }

  private function getMessage(string $roomId) {
    $messageInfo = new \stdClass();
    $message = new Message();
    $messageInfo->notReadNum = $message->getNotReadMessage($roomId);
    $lastMessage = $message->getLastMessage($roomId);
    $messageInfo->lastSendTime = $lastMessage->createAt;
    $messageInfo->lastMessage = $lastMessage->content;
    return $messageInfo;
  }
}