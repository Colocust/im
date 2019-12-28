<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/10
 * Time: 17:20
 */

namespace db;


use tiny\MongoDB;

class Room extends MongoDB {
  protected $table = "Room";
}