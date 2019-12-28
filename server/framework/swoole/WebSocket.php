<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/12
 * Time: 14:20
 */

namespace tiny\swoole;


use tiny\Logger;

class WebSocket {
  private static $instance = null;

  private function __construct() {
    $ws = new swoole_websocket_server(config('swoole.websocket.host'), config('swoole.websocket.port'));

    $ws->on('open', [$this, 'onOpen']);

    $ws->on('message', [$this, 'onMessage']);

    $ws->on('close', [$this, 'onClose']);

    $ws->start();
  }

  public static function getInstance(): WebSocket {
    if (self::$instance === null)
      self::$instance = new static();
    return self::$instance;
  }

  public function onOpen($ws, $request) {
    Logger::getInstance()->info('request' . json_encode($request));
  }

  //通过uid获取fd
  //判断
  public function onMessage($ws, $frame) {

  }

  //销毁redis
  public function onClose($ws, $fd) {
    Logger::getInstance()->info("{$fd}断开了连接");
  }
}