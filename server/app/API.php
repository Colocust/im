<?php
/**
 * Created by PhpStorm.
 * User: locust
 * Date: 2019/9/23
 * Time: 10:46
 */

namespace api;

use db\MyToken;
use db\MyTokenInfo;
use tiny\Code;
use tiny\HttpStatus;
use tiny\Logger;
use tiny\Net;

abstract class API extends \tiny\API {

  protected $requestData;

  abstract public function requestClass(): Request;

  abstract public function doRun(): Response;

  //requestClass参数验证
  protected function beforeRun(\tiny\Request $request, \tiny\Response $response): bool {

    $this->requestData = $request->data;

    //判断api是否需要参数验证
    if ($this->needValidate() && !app('validate')->goCheck($this->getRequest())) {
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return false;
    }

    return true;
  }

  public function run(\tiny\Request $request, \tiny\Response $response) {
    if ($this->needToken() && !$this->checkToken($request)) {
      $response->data = new ErrorResponse(Code::TOKEN_EXPIRE_CODE, 'token not set or error');
      Logger::getInstance()->warn('token not set or error');
      return;
    }
    $response->data = $this->doRun();
  }

  //验证responseClass
  protected function afterRun(\tiny\Request $request, \tiny\Response $response) {
    if ($this->needValidate() && !app('validate')->goCheck($response->data, $response->data)) {
      $response->httpStatus = HttpStatus::ARGS_ERROR;
      return false;
    }
    return true;
  }

  //检测此API是否需要token
  protected function needToken(): bool {
    return true;
  }

  //检测次API是否需要进行参数验证
  protected function needValidate(): bool {
    return true;
  }

  //校验token
  private function checkToken(\tiny\Request $request): bool {
    if (empty($request->token) || !is_string($request->token)) {
      return false;
    }
    $info = new MyTokenInfo();
    $token = new MyToken($request->token);
    if (!$token->getToken($info)) {
      return false;
    }
    //创建网络层
    app('net')->createNet($info);
    return true;
  }

  //获取请求APIRequest
  public function getRequest(): Request {
    $requestClass = $this->requestClass();
    foreach ($requestClass as $k => $v) {
      if (isset($this->requestData->{$k})) {
        $requestClass->{$k} = $this->requestData->{$k};
      }
    }
    return $requestClass;
  }

  //获取当前网络信息
  protected function getNet(): Net {
    return app('net');
  }
}