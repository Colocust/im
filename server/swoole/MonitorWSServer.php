<?php


namespace swoole;

use tiny\Container;
use tiny\Loader;
use tiny\Logger;

require '../framework/Loader.php';
Loader::register();
Container::get("app")->initialize();

//监控WS_Server服务
class MonitorWSServer {
  const PORT = 9501;

  public function port() {
    $shell = "netstat -anp 2>/dev/null | grep " . self::PORT . " | grep LISTEN | wc -l";
    $result = shell_exec($shell);
    if ($result) {
      Logger::getInstance()->info('WebSocket服务开启成功');
      return;
    }
    Logger::getInstance()->error('WebSocket服务未开启!');
    return;
  }
}

//暂时一个小时监控一次36000000
swoole_timer_tick(36000000, function ($timer_id) {
  (new MonitorWSServer())->port();
});
