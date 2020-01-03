<?php

namespace tiny;

class App {
  //根路径
  private $rootPath;
  //配置文件路径
  private $configPath;
  //默认配置文件为php文件
  private $fileExt = '.php';
  //公共文件路径
  private $commonPath;

  public function run(): void {
    //初始化文件
    $this->initialize();

    //分析路由,找到API
    app('main')->run();
  }

  //初始化各路径
  public function initialize(): void {
    $this->rootPath = $this->getRootPath();
    $this->configPath = $this->rootPath . 'config';
    $this->commonPath = $this->rootPath . 'common';
    $this->initFile();
  }

  //初始化文件
  public function initFile(): void {
    //加载公共文件 common路径
    if (is_dir($this->rootPath . 'common')) {
      $commonDir = $this->commonPath . DIRECTORY_SEPARATOR;
    }
    $commonFiles = isset($commonDir) ? scandir($commonDir) : [];
    foreach ($commonFiles as $commonFile) {
      if ('.' . pathinfo($commonFile, PATHINFO_EXTENSION) === $this->fileExt) {
        include $this->commonPath . DIRECTORY_SEPARATOR . $commonFile;
      }
    }

    //加载配置文件 config路径
    if (is_dir($this->configPath)) {
      $configDir = $this->configPath . DIRECTORY_SEPARATOR;
    }
    $configFiles = isset($configDir) ? scandir($configDir) : [];
    foreach ($configFiles as $configFile) {
      if ('.' . pathinfo($configFile, PATHINFO_EXTENSION) === $this->fileExt) {
        app('config')->loadFile($configDir . $configFile, pathinfo($configFile, PATHINFO_FILENAME));
      }
    }
  }

  private function getRootPath(): string {
    $scriptName = 'cli' == PHP_SAPI ? realpath($_SERVER['argv'][0]) : $scriptName = $_SERVER['SCRIPT_FILENAME'];
    return dirname(realpath(dirname($scriptName))) . DIRECTORY_SEPARATOR;
  }
}