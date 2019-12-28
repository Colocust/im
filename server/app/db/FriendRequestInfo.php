<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:18
 */

namespace db;


class FriendRequestInfo {
  public $_id;
  public $senderUid;   //string
  public $receiverUid; //string
  public $state;       //int  0未处理 1同意 2失败
  public $createAt;    //int
}