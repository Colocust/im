<?php

namespace db;


class MessageInfo {
  public $_id;
  public $room_id;     //string
  public $senderUid;   //string
  public $receiverUid; //string
  public $content;     //string
  public $createAt;    //int
}