<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:48
 */

namespace tiny;


class Config {

  //config值
  protected $config = [];

  //准备加载配置文件
  public function loadFile(string $file, string $fileName = ""): array {
    //文件名初始化为小写
    $fileName = strtolower($fileName);
    $fileType = pathinfo($file, PATHINFO_EXTENSION);
    return $this->parseFile($file, $fileType, $fileName);
  }

  //解析文件
  public function parseFile(string $file, string $fileType, string $fileName): array {
    $object = Loader::factory($fileType, '\\tiny\\config\\driver\\');
    return $this->setConfigValue($object->parse($file), $fileName);
  }

  //设置配置文件值
  public function setConfigValue(array $values, string $configName): array {
    $result = (isset($this->config[$configName])) ? array_merge($this->config[$configName], $values) : $values;
    $this->config[$configName] = $result;
    return $result;
  }

  //获取配置
  public function get($name = null) {
    if (empty($name)) return $this->config;
    $names = explode('.', $name);
    $names[0] = strtolower($names[0]);
    $config = $this->config;
    foreach ($names as $name) {
      if (isset($config[$name])) {
        $config = $config[$name];
      } else {
        return null;
      }
    }
    return $config;
  }
}