<?php

namespace service;

use tiny\Logger;

class Upload {
  //文件上传的路径
  private static $path;

  //文件后缀名
  private static $ext;

  //文件大小的限制,默认最大为500kb,单位为byte
  private static $max_size = 512000;

  public static function uploadFile($file) {
    self::$path = dirname(__DIR__)
      . DIRECTORY_SEPARATOR
      . config('app.upload_file_folder')
      . DIRECTORY_SEPARATOR;
    $temp = explode(".", $file['name']);
    self::$ext = end($temp);
    //文件上传错误
    if ($file['error'] !== 0) {
      Logger::getInstance()->error('文件上传错误');
      return false;
    }

    //文件超出大小限制.默认为500kb
    if ($file['size'] > self::$max_size) {
      Logger::getInstance()->error('文件大小超出最大限制,此文件大小为' . $file['size']);
      return false;
    }

    $fileName = self::makeFileName();
    move_uploaded_file($file['tmp_name'],
      self::$path . $fileName . '.' . self::$ext);
    return config('app.upload_file_url') . $fileName . '.' . self::$ext;
  }

  //生成文件名,可自定义
  private static function makeFileName(): string {
    return md5(uniqid());
  }
}