<?php

namespace tiny;

class Main {
  //目标路由
  private $redirect_url;

  private $path_info;

  public function run() {
    ini_set('date.timezone', 'Asia/Shanghai');
    ini_set('display_errors', 'Off');
    error_reporting(E_ALL);

    $softWare = $_SERVER['SERVER_SOFTWARE'];

    //兼容Apache以及Nginx
    $_SERVER['API_URI'] = strstr($softWare, 'Apache')
      ? $_SERVER['PATH_INFO']
      : $_SERVER['REQUEST_URI'];

    if (!isset($_SERVER['API_URI'])) {
      http_response_code(HttpStatus::NOT_FOUND);
      Logger::getInstance()->error('404 API NOT FOUND');
      return;
    }
    $this->path_info = $_SERVER['API_URI'];
    $this->redirect_url = str_replace('/', '\\', $this->path_info);
    try {
      $reflection = new \ReflectionClass($this->redirect_url);
    } catch (\ReflectionException $e) {
      http_response_code(HttpStatus::NOT_FOUND);
      Logger::getInstance()->error('404 API NOT FOUND');
      return;
    }


    if (strtolower($_SERVER['REQUEST_METHOD']) == 'options') {
      $httpHeaders["Access-Control-Allow-Origin"] = "*";
      $httpHeaders["Access-Control-Max-Age"] = 24 * 3600;
      $httpHeaders["Access-Control-Allow-Headers"] =
        " accept, content-type, _t, _i, _f, _l, _s,Accept-Language,"
        . "Content-Language,Origin, No-Cache, X-Requested-With, If-Modified-Since,"
        . " Pragma, Last-Modified, Cache-Control, Expires, Content-Type, "
        . "X-E4M-With,authorization,application/x-www-form-urlencoded,multipart/form-data,text/plain";
      $httpHeaders["Access-Control-Allow-Methods"] = " OPTIONS, POST";
      foreach ($httpHeaders as $header => $value) {
        header($header . ': ' . $value);
      }
      return;
    }

    //判断请求类型
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
      http_response_code(HttpStatus::FAILED);
      Logger::getInstance()->error('目前仅支持POST,这是一个错误的请求方式');
      return;
    }

    set_error_handler(function ($errno, $errStr, $errFile, $errLine) {
      /**
       * 错误控制运算符：@ 标注的忽略错误不再输出
       */
      if (error_reporting() === 0) {
        return false;
      }
      throw new \ErrorException($errStr, 0, $errno, $errFile, $errLine);
    });


    try {
      Logger::getInstance()->info('start');

      $request = new Request();


      if (json_decode(file_get_contents("php://input"))) {
        $data = toArray(json_decode(file_get_contents("php://input")));
      } else {
        $data = array_merge($_POST, $_FILES);
      }

      $request->data = new \stdClass();

      if ($data) {
        foreach ($data as $k => $v) {
          $request->data->{$k} = $v;
        }
      }

      if (isset($request->data->token)) {
        $request->token = $request->data->token;
        unset($request->data->token);
      }


      $response = new Response();
      $reflection->newInstanceArgs()->process($request, $response);

      // ------ response -------
      Logger::getInstance()->info("end");

      //返回客户端信息
      http_response_code($response->httpStatus);
      if ($response->httpStatus == HttpStatus::SUC) {
        foreach ($response->httpHeaders as $header => $value) {
          header($header . ': ' . $value);
        }
        echo json_encode($response->data);
      }
    } catch (\Exception $e) {
      http_response_code(HttpStatus::FAILED);
      Logger::getInstance()->fatal($e);
    } catch (\Error $e) {
      http_response_code(HttpStatus::FAILED);
      Logger::getInstance()->fatal($e);
    }
  }
}