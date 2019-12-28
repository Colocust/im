<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:27
 */

namespace db;


class MessageInfo {
  public $_id;
  public $room_id;     //string
  public $senderUid;   //string
  public $receiverUid; //string
  public $content;     //string
  public $createAt;    //int
}