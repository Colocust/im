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
      $messageInfo = $this->getMessage($one->_id);
      if (!$messageInfo) {
        continue;
      }
      $item = new GetMyRoomResponseItem();
      $item->roomId = $one->_id;
      $item->notReadNum = $messageInfo->notReadNum;
      $item->lastSendTime = $messageInfo->lastSendTime;
      $item->lastMessage = $messageInfo->lastMessage;


      $memberInfo = $this->getMemberInfo($one->members);
      $item->memberId = $memberInfo->memberId;
      $item->memberAvatar = $memberInfo->avatar;
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
      $memberInfo->nickname = $userInfo->nickname;
      $memberInfo->memberId = $userInfo->_id;
      return $memberInfo;
    }
    return $memberInfo;
  }

  private function getMessage(string $roomId) {
    $messageInfo = new \stdClass();
    $message = new Message();
    $notReadNum = 0;
    $notReadMessages = $message->getNotReadMessage($roomId);
    foreach ($notReadMessages as $notReadMessage) {
      if ($notReadMessage->receiveUid == $this->getNet()->getUID()) $notReadNum++;
    }
    $messageInfo->notReadNum = $notReadNum;
    $lastMessage = $message->getLastMessage($roomId);
    if (!$lastMessage) {
      return false;
    }
    $messageInfo->lastSendTime = $this->getLastSendTime($lastMessage->createAt);
    $messageInfo->lastMessage = $lastMessage->content;
    return $messageInfo;
  }

  private function getLastSendTime(int $time): string {
    return date('m-d H:i', $time / 1000);
  }

}