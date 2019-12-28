<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/12/11
 * Time: 16:26
 */


class WebSocketServer {

  public function __construct() {
    $ws = new swoole_websocket_server(config('swoole.websocket.host'), config('swoole.websocket.port'));

    $ws->on('open', [$this, 'onOpen']);

    $ws->on('message', [$this, 'onMessage']);

    $ws->on('close', [$this, 'onClose']);

    $ws->start();
  }

  public function onOpen($ws, $request) {

  }

  public function onMessage($ws, $frame) {

  }

  public function onClose($ws, $fd) {

  }
}

$ws = new WebSocketServer();