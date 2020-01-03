<?php

namespace tiny\config\driver;


interface Driver {
  /**
   * @param string $config
   * @return array
   */
  //解析文件
  public function parse(string $config): array;
}