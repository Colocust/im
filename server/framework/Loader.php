<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:48
 */

namespace tiny;

class Loader {
  //文件后缀名
  private static $fileExt = '.php';

  //定义命名空间规则
  private static $prefixLengthsPsr4 = [
    'a' =>
      array(
        'api\\' => 4
      ),
    'd' =>
      array(
        'db\\' => 3
      ),
    's' =>
      array(
      'service\\' => 8
    ),
    't' =>
      array(
        'tiny\\' => 5,
      )
  ];

  private static $fallbackDirsPsr4 = [];

  //定义命名空间指定文件路径
  private static $prefixDirsPsr4 = [
    'api\\' =>
      array(
        0 => __DIR__ . '/../app/api',
        1 => __DIR__ . '/../app/parameter',
        2 => __DIR__ . '/../app'
      ),
    'db\\' =>
      array(
        0 => __DIR__ . '/../app/db'
      ),
    'service\\' =>
      array(
        0 => __DIR__ . '/../service'
      ),
    'tiny\\' =>
      array(
        0 => __DIR__
      )
  ];

  //自动注册指定类
  public static function register(): void {
    spl_autoload_register('tiny\\Loader::autoload', true, true);
    $rootPath = self::getRootPath();
    // 自动加载extend目录
    self::addAutoLoadDir($rootPath . 'extend');
  }

  //找到指定类的文件并加载
  public static function autoload(string $class) {
    if ($file = self::findFile($class)) include $file;
  }

  public static function findFile(string $class) {
    //将class中的\\转换为/,并在末尾加上.php文件扩展名
    $logicalPathPsr4 = strtr($class, '\\', DIRECTORY_SEPARATOR) . self::$fileExt;
    //找到指定类在$prefixLengthPsr4中定义的可能的命名空间名
    $prefixLengthPsr4Name = $class[0];

    if (isset(self::$prefixLengthsPsr4[$prefixLengthPsr4Name])) {
      foreach (self::$prefixLengthsPsr4[$prefixLengthPsr4Name] as $prefix => $length) {
        if (strpos($class, $prefix) == 0) {
          //通过文件名找指定类
          foreach (self::$prefixDirsPsr4[$prefix] as $dir) {
            if (is_file($file = $dir . DIRECTORY_SEPARATOR . substr($logicalPathPsr4, $length))) {
              return $file;
            }
          }
        }
      }
    }


    foreach (self::$fallbackDirsPsr4 as $dir) {
      if (is_file($file = $dir . DIRECTORY_SEPARATOR . $logicalPathPsr4)) {
        return $file;
      }
    }

    return false;
  }

  //创建工厂模式,加载不同类型的文件
  public static function factory(string $name, string $namespace = "") {
    $class = false !== strpos($name, '\\') ? $name : $namespace . ucwords($name);
    if (class_exists($class)) {
      return Container::getInstance()->invokeClass($class);
    }
    throw new \Exception('class not found', 404);
  }

  public static function addAutoLoadDir($path) {
    self::$fallbackDirsPsr4[] = $path;
  }

  // 获取应用根目录
  public static function getRootPath() {
    if ('cli' == PHP_SAPI) {
      $scriptName = realpath($_SERVER['argv'][0]);
    } else {
      $scriptName = $_SERVER['SCRIPT_FILENAME'];
    }

    $path = dirname(realpath(dirname($scriptName)));

    return $path . DIRECTORY_SEPARATOR;
  }
}
