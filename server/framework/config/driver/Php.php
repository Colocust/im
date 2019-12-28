<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/24
 * Time: 10:18
 */

namespace tiny\config\driver;

class Php implements Driver {

  public function parse(string $config): array {
    return include $config;
  }
}