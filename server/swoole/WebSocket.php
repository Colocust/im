<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:46
 */


use tiny\Container;
use tiny\Loader;
use tiny\Logger;

require '../framework/Loader.php';

Loader::register();
Container::get("app")->initialize();


class WebSocket {
  private static $instance = null;

  public function __construct() {
    $ws = new swoole_websocket_server(config('swoole.websocket.host'), config('swoole.websocket.port'));

    $ws->on('open', [$this, 'onOpen']);
    $ws->on('message', [$this, 'onMessage']);
    $ws->on('task', [$this, 'onTask']);
    $ws->on('finish', [$this, 'onFinish']);
    $ws->on('close', [$this, 'onClose']);

    $ws->set([
      'worker_num' => 8,
      'task_worker_num' => 8,
    ]);
    $ws->start();
  }

  public static function getInstance(): WebSocket {
    if (self::$instance === null)
      self::$instance = new static();
    return self::$instance;
  }

  public function onOpen($ws, $request) {
    Logger::getInstance()->info('连接成功');
    Logger::getInstance()->info('request' . json_encode($request));
  }

  //通过uid获取fd
  //判断
  public function onMessage($ws, $frame) {
    Logger::getInstance()->info('frame' . json_encode($frame));
    Logger::getInstance()->info('receive' . $frame->data);

    $data = [
      'hh' => '1'
    ];
    $ws->task($data);

    $ws->push($frame->fd, time());
  }


  //销毁redis
  public function onClose($ws, $fd) {
    // Logger::getInstance()->info("{$fd}断开了连接");
  }

  public function onTask(swoole_server $server, int $taskId, int $workId, $data) {
    Logger::getInstance()->info('task' . json_encode($data));
    sleep(10);
    return "finish";
  }

  public function onFinish(swoole_server $server, int $taskId, $data) {
    Logger::getInstance()->info('finish');
  }
}

$ws = new WebSocket();