<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:26
 */

namespace db;


use tiny\MongoDB;

class Message extends MongoDB {
  protected $table = "Message";
}