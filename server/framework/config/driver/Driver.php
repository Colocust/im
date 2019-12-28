<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/24
 * Time: 10:34
 */

namespace tiny\config\driver;


interface Driver {
  /**
   * @param string $config
   * @return array
   */
  //解析文件
  public function parse(string $config): array;
}