<?php

namespace tiny\config\driver;

class Php implements Driver {

  public function parse(string $config): array {
    return include $config;
  }
}