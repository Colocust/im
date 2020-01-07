<?php


namespace api;


class GetMessageInfoRequest extends Request {
  /**
   * @var string[]
   * @uses required
   */
  public $messageIds;
  /**
   * @var string[]
   * @uses required
   */
  public $fields;

  const id = "id";
  const room_id = "room_id";     //string
  const senderUid = 'senderUid';   //string
  const receiverUid = "receiverUid"; //string
  const content = "content";     //string
  const state = "state";
  const createAt = "createAt";    //int
}